<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    /**
     * Các key được phép lưu, kèm luật kiểm tra.
     */
    const RULES = [
        // Nút mạng xã hội nổi bên phải
        'social_tiktok' => 'nullable|url|max:500',
        'social_facebook' => 'nullable|url|max:500',
        'social_zalo' => 'nullable|url|max:500',

        // Footer: giới thiệu + icon mạng xã hội
        'footer_intro' => 'nullable|string|max:2000',
        'footer_tiktok' => 'nullable|url|max:500',
        'footer_facebook' => 'nullable|url|max:500',
        'footer_zalo' => 'nullable|url|max:500',

        // Footer: các ô nhiều dòng, mỗi dòng là 1 mục
        'footer_services' => 'nullable|string|max:2000',
        'footer_office_vn' => 'nullable|string|max:2000',
        'footer_office_kr' => 'nullable|string|max:2000',

        // Footer: liên hệ
        'contact_phone_kr' => 'nullable|string|max:100',
        'contact_phone_vn' => 'nullable|string|max:100',
        'contact_zalo' => 'nullable|string|max:100',
        'contact_email' => 'nullable|email|max:255',

        // Footer: bản đồ + copyright
        'footer_map' => 'nullable|string|max:3000',
        'footer_copyright' => 'nullable|string|max:255',
    ];

    /**
     * Logo: logo_main (logo màu, dùng cho nền sáng + favicon), logo_white (dùng cho nền đỏ/tối).
     * Chỉ thay đổi qua uploadLogo / deleteLogo.
     */
    const LOGO_KEYS = ['logo_main', 'logo_white'];

    /**
     * Trả về dạng { key: value } để giao diện dùng trực tiếp.
     */
    public function index()
    {
        $settings = Setting::query()
            ->whereIn('setting_key', array_merge(array_keys(self::RULES), self::LOGO_KEYS))
            ->pluck('setting_value', 'setting_key');

        return response()->json($settings);
    }

    /**
     * Upload logo mới, xóa file logo cũ.
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'key' => ['required', Rule::in(self::LOGO_KEYS)],
            'logo' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ], [
            'logo.required' => 'Vui lòng chọn ảnh logo.',
            'logo.image' => 'File phải là ảnh.',
            'logo.mimes' => 'Logo phải là ảnh PNG, JPG hoặc WEBP.',
            'logo.max' => 'Ảnh logo tối đa 2MB.',
        ]);

        try {
            $key = $request->input('key');
            $this->deleteLogoFile($key);

            $path = $request->file('logo')->store('uploads/logo', 'public');
            // Lưu đường dẫn tương đối để không phụ thuộc APP_URL
            $url = '/storage/' . $path;
            Setting::query()->updateOrCreate(['setting_key' => $key], ['setting_value' => $url]);

            return response()->json(['success' => true, 'message' => 'Cập nhật logo thành công.', 'data' => $url]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Cập nhật logo thất bại.'], 500);
        }
    }

    /**
     * Xóa logo đã upload, web quay về dùng logo mặc định.
     */
    public function deleteLogo($key)
    {
        if (!in_array($key, self::LOGO_KEYS)) {
            return response()->json(['success' => false, 'message' => 'Logo không hợp lệ.'], 404);
        }

        $this->deleteLogoFile($key);
        Setting::query()->where('setting_key', $key)->delete();

        return response()->json(['success' => true, 'message' => 'Đã khôi phục logo mặc định.']);
    }

    private function deleteLogoFile(string $key): void
    {
        $oldUrl = Setting::query()->where('setting_key', $key)->value('setting_value');
        if ($oldUrl && str_starts_with($oldUrl, '/storage/')) {
            Storage::disk('public')->delete(substr($oldUrl, strlen('/storage/')));
        }
    }

    /**
     * Lưu nhiều key một lần.
     */
    public function update(Request $request)
    {
        $data = $request->validate(self::RULES, [
            'url' => 'Link không hợp lệ, phải bắt đầu bằng https://',
            'email' => 'Email không hợp lệ.',
        ]);

        // Cho phép dán cả đoạn <iframe ...> của Google Maps, chỉ giữ lại link trong src
        if (!empty($data['footer_map']) && preg_match('~src="([^"]+)"~', $data['footer_map'], $matches)) {
            $data['footer_map'] = html_entity_decode($matches[1]);
        }
        if (!empty($data['footer_map']) && !str_starts_with($data['footer_map'], 'https://www.google.com/maps/embed')) {
            return response()->json([
                'message' => 'Bản đồ không hợp lệ.',
                'errors' => ['footer_map' => ['Bản đồ phải là link nhúng của Google Maps (Chia sẻ → Nhúng bản đồ).']],
            ], 422);
        }

        try {
            foreach ($data as $key => $value) {
                Setting::query()->updateOrCreate(
                    ['setting_key' => $key],
                    ['setting_value' => $value ?? '']
                );
            }
            return response()->json(['success' => true, 'message' => 'Lưu cài đặt thành công.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lưu cài đặt thất bại.'], 500);
        }
    }
}
