<?php

namespace Database\Seeders;

use App\Models\PostType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'type_name'=> 'Tin tức và sự kiện',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'type_name'=> 'Du học hàn quốc',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'type_name'=> 'Học bổng',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'type_name'=> 'Cẩm nang du học',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert dữ liệu vào bảng
        foreach ($data as $i) {
            PostType::create($i);
        }
    }
}
