<?php

namespace Database\Seeders;

use App\Models\Posts;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Bài viết mẫu (nội dung trong database/seeders/data/posts_*.php).
     * Chạy lại nhiều lần không bị trùng: bài có cùng slug sẽ được cập nhật.
     * Cần chạy PostTypesTableSeeder trước để có danh mục.
     */
    public function run(): void
    {
        $posts = array_merge(
            require __DIR__ . '/data/posts_tuyen_sinh.php',
            require __DIR__ . '/data/posts_du_hoc.php',
        );

        $categories = PostType::query()->get(['id', 'type_name'])
            ->keyBy(fn ($type) => mb_strtolower($type->type_name));
        $authorId = User::query()->value('id') ?? 1;

        foreach ($posts as $index => $data) {
            $postTypes = collect($data['categories'])
                ->map(fn ($name) => $categories->get(mb_strtolower($name)))
                ->filter()
                ->map(fn ($type) => ['id' => $type->id, 'name' => $type->type_name])
                ->values()
                ->all();

            $post = Posts::query()->firstOrNew(['slug' => $data['slug']]);
            $post->fill([
                'title' => $data['title'],
                'description' => $data['description'],
                'content' => implode("\n", $data['content']),
                'thumbnail' => '/assets/images/blog/' . $data['image'],
                'post_type_id' => json_encode($postTypes, JSON_UNESCAPED_UNICODE),
                'author_id' => $authorId,
                'type' => '0',
                'university_info' => null,
            ]);
            // Rải ngày đăng để danh sách bài trông tự nhiên
            $publishedAt = now()->subDays($data['days_ago'])->setTime(8 + $index % 10, ($index * 7) % 60);
            $post->created_at = $publishedAt;
            $post->updated_at = $publishedAt;
            $post->save();
        }
    }
}
