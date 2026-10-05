<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Nạp toàn bộ dữ liệu mẫu cho website bằng một lệnh:
 *
 *     php artisan db:seed --class=SampleDataSeeder
 *
 * Gồm: danh mục, bài viết, menu, banner. Chạy lại nhiều lần không bị trùng dữ liệu.
 * Lưu ý: MenuSeeder xóa toàn bộ menu hiện có rồi tạo lại menu mẫu.
 */
class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Bài viết cần có tác giả
        if (!User::query()->exists()) {
            $this->call(UsersTableSeeder::class);
        }

        $this->call([
            PostTypesTableSeeder::class,
            PostsTableSeeder::class,
            MenuSeeder::class,
            BannersTableSeeder::class,
        ]);
    }
}
