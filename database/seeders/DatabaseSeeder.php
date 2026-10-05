<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(ConsultationRequestsTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(TikTokVideosTableSeeder::class);

        // Danh mục, bài viết, menu, banner mẫu (chạy riêng: php artisan db:seed --class=SampleDataSeeder)
        $this->call(SampleDataSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
