<?php

namespace Database\Seeders;

use App\Models\TikTokVideo;
use Illuminate\Database\Seeder;

class TikTokVideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'video_title' => 'Con Trai Thì Nên Học Ngành Gì Tại Hàn Quốc',
                'video_url' => 'https://www.tiktok.com/@du.hc.smartedu/video/7379230454425193729',
                'author_username' => '@du.hc.smartedu',
            ],
            [
                'video_title' => 'Ai Hiểu Biết Về Điện Ảnh Và Ẩm Thực Của Hàn Quốc Hơn',
                'video_url' => 'https://www.tiktok.com/@du.hc.smartedu/video/7378117177376836881',
                'author_username' => '@du.hc.smartedu',
            ],
            [
                'video_title' => 'Chia Sẻ Kinh Nghiệm Du Học Hàn Quốc',
                'video_url' => 'https://www.tiktok.com/@du.hc.smartedu/video/7384067532929518865',
                'author_username' => '@du.hc.smartedu',
            ],
        ];

        // Trang chủ hiển thị video mới thêm trước, nên video cuối mảng sẽ đứng đầu
        // Video mẫu: chỉ thêm khi cài mới (bảng còn trống), không đụng video đã quản lý trong admin
        if (TikTokVideo::query()->exists()) {
            return;
        }
        foreach ($data as $i) {
            TikTokVideo::create($i);
        }
    }
}
