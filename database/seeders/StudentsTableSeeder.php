<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name'=> 'Nguyễn Ánh Dương 1',
                'email' => 'duongna16@gmail.com',
                'phone_number' => '0399090988',
                'date_of_birth' => '2024-05-21',
                'gender' => 'M',
                'nationality' => 'VIE',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name'=> 'Nguyễn Ánh Dương 2',
                'email' => 'duongna16@gmail.com',
                'phone_number' => '0399090988',
                'date_of_birth' => '2024-05-21',
                'gender' => 'F',
                'nationality' => 'VIE',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name'=> 'Nguyễn Ánh Dương 3',
                'email' => 'duongna16@gmail.com',
                'phone_number' => '0399090988',
                'date_of_birth' => '2024-05-21',
                'gender' => 'Other',
                'nationality' => 'VIE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert dữ liệu vào bảng
        foreach ($data as $i) {
            Student::create($i);
        }
    }
}
