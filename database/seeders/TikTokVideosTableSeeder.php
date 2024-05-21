<?php

namespace Database\Seeders;

use App\Models\TikTokVideo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'video_title' => 'Tiktok duongna',
                'video_url' => 'https://www.tiktok.com/@thobaymau_anime/video/7359591894101364011',
                'author_username' => '@anhduong',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'video_title' => 'Tiktok duongna',
                'video_url' => 'https://www.tiktok.com/@thobaymau_anime/video/7359591894101364011',
                'author_username' => '@anhduong',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'video_title' => 'Tiktok duongna',
                'video_url' => 'https://www.tiktok.com/@thobaymau_anime/video/7359591894101364011',
                'author_username' => '@anhduong',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert dữ liệu vào bảng
        foreach ($data as $i) {
            TikTokVideo::create($i);
        }
    }
}
