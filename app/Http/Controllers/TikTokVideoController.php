<?php

namespace App\Http\Controllers;

use App\Models\TikTokVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TikTokVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TikTokVideo::query()->orderBy('id', 'desc')->get();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $this->validateVideo($request);
            $this->ensureNotDuplicate($data['video_url']);
            $video = TikTokVideo::create($data);
            return response()->json(['success' => true, 'message' => 'Thêm video thành công.', 'data' => $video]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Thêm video thất bại.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $video = TikTokVideo::find($id);
        if ($video) {
            return response()->json(['success' => true, 'data' => $video]);
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy video.'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $video = TikTokVideo::query()->findOrFail($id);
            $data = $this->validateVideo($request);
            $this->ensureNotDuplicate($data['video_url'], $video->id);
            $video->update($data);
            return response()->json(['success' => true, 'message' => 'Cập nhật video thành công.', 'data' => $video]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Cập nhật video thất bại.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            TikTokVideo::query()->findOrFail(intval($id))->delete();
            return response()->json(['success' => true, 'message' => 'Xóa video thành công.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Xóa video thất bại.'], 500);
        }
    }

    /**
     * Không cho thêm cùng một video 2 lần (TikTok chặn khi nhúng trùng video trên một trang).
     */
    private function ensureNotDuplicate(string $videoUrl, $exceptId = null): void
    {
        $exists = TikTokVideo::query()
            ->where('video_url', $videoUrl)
            ->when($exceptId, fn($query) => $query->where('id', '!=', $exceptId))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages(['video_url' => 'Video này đã có trong danh sách.']);
        }
    }

    /**
     * Kiểm tra link TikTok và lấy username từ link.
     */
    private function validateVideo(Request $request): array
    {
        $request->validate([
            'video_url' => ['required', 'url', 'regex:' . TikTokVideo::URL_PATTERN],
            'video_title' => 'nullable|string|max:255',
        ], [
            'video_url.required' => 'Vui lòng nhập link video.',
            'video_url.url' => 'Link video không hợp lệ.',
            'video_url.regex' => 'Link phải có dạng https://www.tiktok.com/@username/video/123... (mở video trên trình duyệt rồi copy link).',
        ]);

        preg_match(TikTokVideo::URL_PATTERN, $request->input('video_url'), $matches);

        return [
            // Bỏ phần ?_r=1&_t=... phía sau link
            'video_url' => "https://www.tiktok.com/@{$matches[1]}/video/{$matches[2]}",
            'video_title' => $request->input('video_title') ?? '',
            'author_username' => '@' . $matches[1],
        ];
    }
}
