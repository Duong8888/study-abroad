<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    // type 0: slider đầu trang chủ (bấm vào mở link)
    // type 1: thư viện "Một số hình ảnh của SMARTEDU" (bấm vào phóng to ảnh)
    const TYPE_SLIDER = 0;
    const TYPE_GALLERY = 1;

    // Ảnh mẫu nằm trong public/assets/images/banner/smartedu/
    const IMAGE_DIR = '/assets/images/banner/smartedu/';

    const BANNERS = [
        ['type' => self::TYPE_SLIDER, 'title' => 'Du học Hàn Quốc cùng SMART EDU', 'image' => 'slider-1.jpg', 'link' => '/blogs/he-tieng-han-visa-d4-1'],
        ['type' => self::TYPE_SLIDER, 'title' => '5 lí do nên chọn du học Hàn Quốc', 'image' => 'slider-2.jpg', 'link' => '/blogs/chi-phi-du-hoc-han-quoc-2026'],

        ['type' => self::TYPE_GALLERY, 'title' => 'SMART EDU – Nơi gửi trọn niềm tin', 'image' => 'poster.jpg', 'link' => '/blogs/gioi-thieu-smartedu'],
        ['type' => self::TYPE_GALLERY, 'title' => 'Khuôn viên trường đại học tại Seoul', 'image' => 'campus-1.jpg', 'link' => '/blogs/dai-hoc-top-khu-vuc-seoul'],
        ['type' => self::TYPE_GALLERY, 'title' => 'Khuôn viên trường đại học đối tác', 'image' => 'campus-2.jpg', 'link' => '/blogs/truong-dai-hoc-visa-thang-han-quoc'],
        ['type' => self::TYPE_GALLERY, 'title' => 'Buổi tư vấn du học tại văn phòng', 'image' => '/assets/images/blog/main-home/2.jpg', 'link' => '/blogs/quy-trinh-tu-van-du-hoc-tai-smartedu'],
        ['type' => self::TYPE_GALLERY, 'title' => 'Học viên ôn luyện TOPIK', 'image' => '/assets/images/blog/inner/1.jpg', 'link' => '/blogs/lo-trinh-hoc-tieng-han-thi-topik'],
        ['type' => self::TYPE_GALLERY, 'title' => 'Hội thảo du học Hàn Quốc', 'image' => '/assets/images/blog/main-home/1.jpg', 'link' => '/blogs/hoi-thao-du-hoc-han-quoc-thang-11'],
    ];

    /**
     * Chạy lại nhiều lần không bị trùng: chỉ xóa và tạo lại các banner mẫu do seeder này tạo,
     * không đụng tới banner bạn tự tải lên trong admin.
     */
    public function run(): void
    {
        $seededPaths = array_map(fn ($banner) => $this->imagePath($banner['image']), self::BANNERS);

        Banner::query()
            ->whereIn('image_path', $seededPaths)
            // Banner mẫu cũ trỏ tới ảnh không tồn tại (./images/banner/1.jpg)
            ->orWhere('image_path', 'like', './images/%')
            ->delete();

        foreach (self::BANNERS as $banner) {
            Banner::create([
                'title' => $banner['title'],
                'image_path' => $this->imagePath($banner['image']),
                'link' => $banner['link'],
                'type' => $banner['type'],
            ]);
        }
    }

    private function imagePath(string $image): string
    {
        return str_starts_with($image, '/') ? $image : self::IMAGE_DIR . $image;
    }
}
