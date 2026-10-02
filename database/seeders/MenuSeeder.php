<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Header hiển thị menu theo thứ tự id, menu cha có menu con sẽ chỉ mở dropdown (href = '#').
     * Chỉ dùng các route đang có trong resources/js/router/index.js.
     *
     * @return void
     */
    public function run()
    {
        // Menu chính
        Menu::create([
            'title' => 'Trang chủ',
            'url' => '/',
            'order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'title' => 'Tin tức',
            'url' => '/blogs',
            'order' => 2,
            'is_active' => true,
        ]);

        $notice = Menu::create([
            'title' => 'Thông báo',
            'url' => null,
            'order' => 3,
            'is_active' => true,
        ]);

        // Menu con
        $notice->subMenus()->create([
            'title' => 'Lịch nghỉ lễ 30/4 – 1/5',
            'url' => '/blogs/lich-nghi-le-30-4',
            'order' => 1,
            'is_active' => true,
        ]);

        $notice->subMenus()->create([
            'title' => 'Tất cả bài viết',
            'url' => '/blogs',
            'order' => 2,
            'is_active' => true,
        ]);
    }
}
