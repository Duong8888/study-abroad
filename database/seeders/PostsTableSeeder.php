<?php

namespace Database\Seeders;

use App\Models\Posts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'THÔNG BÁO LỊCH NGHỈ LỄ 30/4 – 1/5',
                'content' => '<figure id="attachment_3079" aria-describedby="caption-attachment-3079" style="width: 2048px" class="wp-caption aligncenter"><figcaption id="caption-attachment-3079" class="wp-caption-text"> <span style="font-size: 110%;">Lịch nghỉ lễ 30/4 – 1/5</span></figcaption></figure>',
                'author_id' => 1,
                'thumbnail' => './images/1.png',
                'post_type_id' => 1,
                'slug'=>'lich-nghi-le-30-4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert dữ liệu vào bảng
        foreach ($data as $i) {
            Posts::create($i);
        }
    }
}
