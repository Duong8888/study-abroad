/**
 * Chuyển chuỗi tiếng Việt thành slug: "Du học Hàn Quốc 2024!" -> "du-hoc-han-quoc-2024"
 */
export function slugify(text) {
    return (text || '')
        .toString()
        .normalize('NFD')
        .replace(/[̀-ͯ]/g, '')
        .replace(/đ/g, 'd')
        .replace(/Đ/g, 'D')
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, ' ')
        .trim()
        .replace(/[\s-]+/g, '-');
}
