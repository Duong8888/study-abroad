<?php

namespace Database\Seeders;

use App\Models\ConsultationRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsultationRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => "Nguyễn Văn Bình",
                'phone_number' => '0392283717',
                'content' => 'em muốn được tư vấn về du học nhận bản',
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => "Nguyễn Văn An",
                'phone_number' => '0392283717',
                'content' => 'em muốn được tư vấn về du học nhận bản',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => "Mai Trường Thịnh",
                'phone_number' => '0392283717',
                'content' => 'em muốn được tư vấn về du học hàn quốc',
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert dữ liệu vào bảng
        foreach ($data as $i) {
            ConsultationRequest::create($i);
        }
    }
}
