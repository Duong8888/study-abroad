// Các khối nội dung dựng sẵn cho menu "Chèn khối" trong trình soạn thảo bài viết.
// Kiểu hiển thị nằm ở resources/css/post-content.css

export const POST_BLOCKS = [
    {
        text: 'Hộp lưu ý (xanh)',
        icon: 'info',
        html: `<div class="callout callout-info"><p><strong class="callout-title">Lưu ý</strong>Nhập nội dung lưu ý tại đây.</p></div><p></p>`,
    },
    {
        text: 'Hộp cảnh báo (cam)',
        icon: 'warning',
        html: `<div class="callout callout-warning"><p><strong class="callout-title">Quan trọng</strong>Nhập nội dung cần chú ý tại đây.</p></div><p></p>`,
    },
    {
        text: 'Hộp mẹo hay (xanh lá)',
        icon: 'checkmark',
        html: `<div class="callout callout-success"><p><strong class="callout-title">Mẹo hay</strong>Nhập mẹo hoặc kinh nghiệm tại đây.</p></div><p></p>`,
    },
    {
        text: 'Tóm tắt nhanh',
        icon: 'unordered-list',
        html: `<div class="key-points"><p class="key-points-title">Tóm tắt nhanh</p><ul><li>Ý chính thứ nhất</li><li>Ý chính thứ hai</li><li>Ý chính thứ ba</li></ul></div><p></p>`,
    },
    {
        text: 'Nút đăng ký tư vấn',
        icon: 'link',
        html: `<div class="post-cta"><p class="post-cta-title">Bạn cần tư vấn lộ trình du học?</p><p>Đội ngũ SMARTEDU hỗ trợ miễn phí từ chọn trường, làm hồ sơ đến xin visa.</p><p><a class="post-btn" href="#form">Đăng ký tư vấn miễn phí</a></p></div><p></p>`,
    },
    {
        text: 'Bảng mẫu 3 cột',
        icon: 'table',
        html: `<table><tbody><tr><td>Tiêu đề cột 1</td><td>Tiêu đề cột 2</td><td>Tiêu đề cột 3</td></tr><tr><td>Nội dung</td><td>Nội dung</td><td>Nội dung</td></tr><tr><td>Nội dung</td><td>Nội dung</td><td>Nội dung</td></tr></tbody></table><p></p>`,
    },
    {
        text: 'Đường phân cách',
        icon: 'horizontal-rule',
        html: `<hr><p></p>`,
    },
];
