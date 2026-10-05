<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Menu chính của website (tối đa 3 cấp).
     * Seeder này XÓA toàn bộ menu hiện có rồi tạo lại theo cấu trúc bên dưới.
     * Các link /blogs/... trỏ tới bài viết mẫu trong PostsTableSeeder.
     */
    const MENU = [
        ['title' => 'Trang chủ', 'url' => '/'],
        ['title' => 'Giới thiệu', 'children' => [
            ['title' => 'Về SMARTEDU', 'url' => '/blogs/gioi-thieu-smartedu'],
            ['title' => 'Quy trình du học 7 bước', 'url' => '/blogs/quy-trinh-tu-van-du-hoc-tai-smartedu'],
        ]],
        ['title' => 'Tuyển sinh', 'children' => [
            ['title' => 'Tuyển sinh Top S.K.Y', 'url' => '/blogs/tuyen-sinh-top-sky'],
            ['title' => 'Tuyển sinh Trường TOP', 'children' => [
                ['title' => 'Trường visa thẳng', 'url' => '/blogs/truong-dai-hoc-visa-thang-han-quoc'],
                ['title' => 'Trường TOP khu vực Seoul', 'url' => '/blogs/dai-hoc-top-khu-vuc-seoul'],
                ['title' => 'Trường TOP khu vực Busan', 'url' => '/blogs/dai-hoc-top-khu-vuc-busan'],
            ]],
            ['title' => 'Hệ tiếng Hàn (Visa D4-1)', 'url' => '/blogs/he-tieng-han-visa-d4-1'],
            ['title' => 'Hệ Đại học (Visa D2-2)', 'url' => '/blogs/he-dai-hoc-visa-d2-2'],
            ['title' => 'Hệ Cao học (Visa D2-3)', 'url' => '/blogs/he-cao-hoc-visa-d2-3'],
            ['title' => 'Du học bằng tiếng Anh', 'url' => '/blogs/du-hoc-han-quoc-bang-tieng-anh'],
            ['title' => 'Du học hệ chuyển tiếp', 'url' => '/blogs/du-hoc-he-chuyen-tiep'],
        ]],
        ['title' => 'Du học Hàn Quốc', 'children' => [
            ['title' => 'Chi phí du học', 'url' => '/blogs/chi-phi-du-hoc-han-quoc-2026'],
            ['title' => 'Điều kiện du học', 'url' => '/blogs/dieu-kien-du-hoc-han-quoc'],
            ['title' => 'Hồ sơ du học', 'url' => '/blogs/ho-so-du-hoc-han-quoc'],
            ['title' => 'Phỏng vấn visa', 'url' => '/blogs/kinh-nghiem-phong-van-visa-du-hoc-han-quoc'],
            ['title' => 'Việc làm thêm', 'url' => '/blogs/viec-lam-them-cho-du-hoc-sinh-han-quoc'],
            ['title' => 'Học bổng', 'children' => [
                ['title' => 'Học bổng Chính phủ GKS', 'url' => '/blogs/hoc-bong-chinh-phu-han-quoc-gks'],
                ['title' => 'Học bổng các trường', 'url' => '/blogs/hoc-bong-cac-truong-dai-hoc-han-quoc'],
            ]],
        ]],
        ['title' => 'Cẩm nang', 'children' => [
            ['title' => 'Học tiếng Hàn & thi TOPIK', 'url' => '/blogs/lo-trinh-hoc-tieng-han-thi-topik'],
            ['title' => 'Chọn ngành học', 'url' => '/blogs/chon-nganh-hoc-tai-han-quoc'],
            ['title' => 'Cuộc sống tại Hàn Quốc', 'url' => '/blogs/cuoc-song-du-hoc-sinh-tai-han-quoc'],
            ['title' => 'Hành lý cần chuẩn bị', 'url' => '/blogs/chuan-bi-truoc-khi-sang-han-quoc'],
        ]],
        ['title' => 'Tin tức', 'url' => '/blogs'],
    ];

    public function run(): void
    {
        DB::transaction(function () {
            // Xóa menu cấp con trước để không vướng khóa ngoại parent_id
            Menu::query()->whereNotNull('parent_id')->delete();
            Menu::query()->delete();
            $this->createItems(self::MENU, null);
        });
    }

    private function createItems(array $items, ?int $parentId): void
    {
        foreach ($items as $index => $item) {
            $menu = Menu::create([
                'parent_id' => $parentId,
                'title' => $item['title'],
                'url' => $item['url'] ?? null,
                'order' => $index + 1,
                'is_active' => true,
            ]);
            if (!empty($item['children'])) {
                $this->createItems($item['children'], $menu->id);
            }
        }
    }
}
