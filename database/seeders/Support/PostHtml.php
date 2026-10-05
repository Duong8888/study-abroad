<?php

namespace Database\Seeders\Support;

/**
 * Dựng HTML nội dung bài viết mẫu.
 * Các class (callout, key-points, post-cta...) khớp với resources/css/post-content.css
 * và các khối trong menu "Chèn khối" của trình soạn thảo.
 */
class PostHtml
{
    public static function e(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    public static function h2(string $text): string
    {
        return '<h2>' . self::e($text) . '</h2>';
    }

    public static function h3(string $text): string
    {
        return '<h3>' . self::e($text) . '</h3>';
    }

    /** Đoạn văn; cho phép <strong>, <em>, <a> trong nội dung */
    public static function p(string $html): string
    {
        return '<p>' . $html . '</p>';
    }

    public static function ul(array $items): string
    {
        return '<ul>' . implode('', array_map(fn ($item) => '<li>' . $item . '</li>', $items)) . '</ul>';
    }

    public static function ol(array $items): string
    {
        return '<ol>' . implode('', array_map(fn ($item) => '<li>' . $item . '</li>', $items)) . '</ol>';
    }

    /** Bảng: hàng đầu tiên là hàng tiêu đề */
    public static function table(array $header, array $rows): string
    {
        $html = '<table><tbody><tr>' . implode('', array_map(fn ($cell) => '<td>' . self::e($cell) . '</td>', $header)) . '</tr>';
        foreach ($rows as $row) {
            $html .= '<tr>' . implode('', array_map(fn ($cell) => '<td>' . self::e($cell) . '</td>', $row)) . '</tr>';
        }
        return $html . '</tbody></table>';
    }

    public static function quote(string $text): string
    {
        return '<blockquote><p>' . self::e($text) . '</p></blockquote>';
    }

    public static function info(string $title, string $html): string
    {
        return self::callout('info', $title, $html);
    }

    public static function warning(string $title, string $html): string
    {
        return self::callout('warning', $title, $html);
    }

    public static function tip(string $title, string $html): string
    {
        return self::callout('success', $title, $html);
    }

    public static function keyPoints(array $items, string $title = 'Tóm tắt nhanh'): string
    {
        return '<div class="key-points"><p class="key-points-title">' . self::e($title) . '</p>' . self::ul($items) . '</div>';
    }

    public static function cta(
        string $title = 'Bạn cần tư vấn lộ trình du học?',
        string $text = 'Đội ngũ SMARTEDU hỗ trợ miễn phí từ chọn trường, làm hồ sơ đến xin visa.',
        string $button = 'Đăng ký tư vấn miễn phí'
    ): string {
        return '<div class="post-cta"><p class="post-cta-title">' . self::e($title) . '</p><p>' . self::e($text) . '</p>'
            . '<p><a class="post-btn" href="#form">' . self::e($button) . '</a></p></div>';
    }

    /** Lưu ý chung cho các bài có số liệu */
    public static function disclaimer(): string
    {
        return self::info(
            'Lưu ý',
            'Số liệu trong bài mang tính tham khảo và có thể thay đổi theo từng trường, từng kỳ tuyển sinh. Liên hệ SMARTEDU để nhận thông tin cập nhật mới nhất.'
        );
    }

    private static function callout(string $type, string $title, string $html): string
    {
        return '<div class="callout callout-' . $type . '"><p><strong class="callout-title">' . self::e($title) . '</strong>' . $html . '</p></div>';
    }
}
