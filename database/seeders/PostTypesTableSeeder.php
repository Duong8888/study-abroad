<?php

namespace Database\Seeders;

use App\Models\PostType;
use Illuminate\Database\Seeder;

class PostTypesTableSeeder extends Seeder
{
    /**
     * Danh mục bài viết. Chạy lại nhiều lần không bị trùng (tìm theo tên).
     * status = 1: hiển thị thành một khối bài viết trên trang chủ.
     */
    const CATEGORIES = [
        ['type_name' => 'Tin tức và sự kiện', 'status' => 1],
        ['type_name' => 'Tuyển sinh', 'status' => 1],
        ['type_name' => 'Du học Hàn Quốc', 'status' => 1],
        ['type_name' => 'Học bổng', 'status' => 1],
        ['type_name' => 'Cẩm nang du học', 'status' => 1],
        ['type_name' => 'Giới thiệu', 'status' => 0],
    ];

    public function run(): void
    {
        foreach (self::CATEGORIES as $category) {
            // So khớp không phân biệt hoa thường để dùng lại danh mục đã có (vd. "Du học hàn quốc")
            $type = PostType::query()
                ->whereRaw('LOWER(type_name) = ?', [mb_strtolower($category['type_name'])])
                ->first() ?? new PostType();
            $type->fill($category)->save();
        }
    }
}
