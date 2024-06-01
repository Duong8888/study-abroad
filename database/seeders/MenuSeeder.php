<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create main menu items
        $home = Menu::create([
            'title' => 'Home',
            'url' => '/',
        ]);

        $about = Menu::create([
            'title' => 'About',
            'url' => '/about',
        ]);

        $blog = Menu::create([
            'title' => 'Blog',
            'url' => '/blogs',
        ]);

        // Create sub menu items
        $about->subMenus()->create([
            'title' => 'Team',
            'url' => '/about/team',
        ]);

        $blog->subMenus()->create([
            'title' => 'News',
            'url' => '/blog/news',
        ]);
    }
}
