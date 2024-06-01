<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Menu;
use http\Message;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(BannersTableSeeder::class);
        $this->call(ConsultationRequestsTableSeeder::class);
        $this->call(PostTypesTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(TikTokVideosTableSeeder::class);
        $this->call(Menu::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
