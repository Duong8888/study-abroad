<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Testimonial::query()->orderBy('id')->get();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'content' => 'required|string',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('uploads/images', 'public');
                $avatarPath = Storage::url($path);
            }

            $testimonial = Testimonial::create([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'avatar' => $avatarPath,
            ]);

            return response()->json(['success' => true, 'message' => 'Thêm cảm nhận thành công.', 'data' => $testimonial]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Thêm cảm nhận thất bại.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $testimonial = Testimonial::find($id);
        if ($testimonial) {
            return response()->json(['success' => true, 'data' => $testimonial]);
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy cảm nhận.'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $testimonial = Testimonial::query()->findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'content' => 'required|string',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($request->hasFile('avatar')) {
                $this->deleteAvatar($testimonial->avatar);
                $path = $request->file('avatar')->store('uploads/images', 'public');
                $testimonial->avatar = Storage::url($path);
            }

            $testimonial->name = $request->input('name');
            $testimonial->content = $request->input('content');
            $testimonial->save();

            return response()->json(['success' => true, 'message' => 'Cập nhật cảm nhận thành công.', 'data' => $testimonial]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Cập nhật cảm nhận thất bại.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $testimonial = Testimonial::query()->findOrFail(intval($id));
            $this->deleteAvatar($testimonial->avatar);
            $testimonial->delete();

            return response()->json(['success' => true, 'message' => 'Xóa cảm nhận thành công.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Xóa cảm nhận thất bại.'], 500);
        }
    }

    private function deleteAvatar(?string $avatar): void
    {
        if ($avatar) {
            // avatar được lưu dạng (APP_URL)/storage/uploads/images/xxx.jpg
            $path = parse_url($avatar, PHP_URL_PATH) ?? '';
            $relative = preg_replace('#^/storage/#', '', $path);
            if ($relative !== $path) {
                Storage::disk('public')->delete($relative);
            }
        }
    }
}
