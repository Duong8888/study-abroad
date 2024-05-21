<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Banner 1',
                'image_path' => './images/banner/1.jpg',
                'link' => 'https://www.facebook.com/',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'title' => 'Banner 2',
                'image_path' => './images/banner/1.jpg',
                'link' => 'https://www.facebook.com/',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'title' => 'Banner 3',
                'image_path' => './images/banner/1.jpg',
                'link' => 'https://www.facebook.com/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert dữ liệu vào bảng
        foreach ($data as $i) {
            Banner::create($i);
        }
    }
}
