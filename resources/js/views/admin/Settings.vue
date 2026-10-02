<template>
    <div class="container pb-5">
        <h4 class="mb-1">Cài đặt chung</h4>
        <p class="text-muted small">Các thông tin lặt vặt hiển thị trên web. Để trống ô nào thì phần đó sẽ bị ẩn.</p>

        <form @submit.prevent="submitForm" style="max-width: 760px">
            <div class="card mb-4" v-for="group in groups" :key="group.title">
                <div class="card-header font-weight-bold">{{ group.title }}</div>
                <div class="card-body">
                    <p v-if="group.desc" class="text-muted small">{{ group.desc }}</p>
                    <div class="form-group" v-for="item in group.fields" :key="item.key">
                        <label :for="item.key" class="d-flex align-items-center">
                            <img v-if="item.icon" :src="item.icon" width="22" height="22" class="mr-2">
                            {{ item.label }}
                        </label>
                        <textarea v-if="item.type === 'textarea'" class="form-control" :id="item.key"
                                  :rows="item.rows || 3" v-model="form[item.key]" :placeholder="item.placeholder"></textarea>
                        <input v-else :type="item.type || 'text'" class="form-control" :id="item.key"
                               v-model="form[item.key]" :placeholder="item.placeholder">
                        <small v-if="item.hint" class="form-text text-muted">{{ item.hint }}</small>
                    </div>
                </div>
            </div>

            <div class="save-bar">
                <button type="submit" class="btn btn-primary" :disabled="loading">Lưu tất cả</button>
            </div>
        </form>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import tiktokIcon from '@/assets/images/common/tiktok_logo.png';
import facebookIcon from '@/assets/images/common/Facebook.png';
import zaloIcon from '@/assets/images/common/Logo-zalo.svg';

const LINE_HINT = 'Mỗi dòng là một mục.';

export default {
    name: "Settings",
    data() {
        const groups = [
            {
                title: 'Nút mạng xã hội nổi',
                desc: '3 nút nổi ở góc phải mọi trang.',
                fields: [
                    {key: 'social_tiktok', label: 'TikTok', icon: tiktokIcon, type: 'url', placeholder: 'https://www.tiktok.com/@du.hc.smartedu'},
                    {key: 'social_facebook', label: 'Facebook', icon: facebookIcon, type: 'url', placeholder: 'https://www.facebook.com/ten-trang'},
                    {key: 'social_zalo', label: 'Zalo', icon: zaloIcon, type: 'url', placeholder: 'https://zalo.me/0329155366', hint: 'Dạng https://zalo.me/ + số điện thoại đăng ký Zalo.'},
                ],
            },
            {
                title: 'Footer - Giới thiệu',
                desc: 'Cột bên trái footer, dưới logo.',
                fields: [
                    {key: 'footer_intro', label: 'Đoạn giới thiệu', type: 'textarea'},
                    {key: 'footer_tiktok', label: 'TikTok', icon: tiktokIcon, type: 'url'},
                    {key: 'footer_facebook', label: 'Facebook', icon: facebookIcon, type: 'url'},
                    {key: 'footer_zalo', label: 'Zalo', icon: zaloIcon, type: 'url'},
                ],
            },
            {
                title: 'Footer - Dịch vụ & Văn phòng',
                fields: [
                    {key: 'footer_services', label: 'Dịch vụ', type: 'textarea', hint: LINE_HINT},
                    {key: 'footer_office_vn', label: 'Văn phòng Việt Nam', type: 'textarea', hint: LINE_HINT + ' Ví dụ: CN1: Số 48, đường Nguyễn Khang, Cầu Giấy, Hà Nội'},
                    {key: 'footer_office_kr', label: 'Văn phòng Hàn Quốc', type: 'textarea', hint: LINE_HINT},
                ],
            },
            {
                title: 'Footer - Liên hệ',
                fields: [
                    {key: 'contact_phone_kr', label: 'SĐT Hàn Quốc', placeholder: '(+82)10 2253 9715'},
                    {key: 'contact_phone_vn', label: 'SĐT Việt Nam', placeholder: '0329 155 366'},
                    {key: 'contact_zalo', label: 'Số Zalo', placeholder: '0329 155 366'},
                    {key: 'contact_email', label: 'Email', type: 'email'},
                ],
            },
            {
                title: 'Footer - Bản đồ & Copyright',
                fields: [
                    {
                        key: 'footer_map', label: 'Bản đồ Google Maps', type: 'textarea', rows: 4,
                        hint: 'Trên Google Maps: tìm địa chỉ → Chia sẻ → Nhúng bản đồ → Sao chép HTML, rồi dán nguyên đoạn đó vào đây.',
                    },
                    {key: 'footer_copyright', label: 'Dòng copyright', placeholder: 'DU HỌC HÀN QUỐC SMARTEDU'},
                ],
            },
        ];

        // Tạo form rỗng với đủ key của mọi nhóm
        const form = {};
        groups.forEach(group => group.fields.forEach(item => form[item.key] = ''));

        return {
            groups,
            form,
            loading: false,
        }
    },
    computed: {
        ...mapGetters('settings', ['settingsAll']),
    },
    watch: {
        settingsAll: {
            handler(newValue) {
                Object.keys(this.form).forEach(key => {
                    this.form[key] = newValue[key] || '';
                });
            },
            immediate: true,
        },
    },
    created() {
        this.fetchSettings();
    },
    methods: {
        ...mapActions('settings', ['fetchSettings', 'updateSettings']),
        async submitForm() {
            this.loading = true;
            await this.updateSettings({data: {...this.form}, toast: this.$toast});
            // Tải lại để lấy giá trị đã được server chuẩn hóa (ví dụ link bản đồ)
            await this.fetchSettings();
            this.loading = false;
        }
    }
}
</script>

<style scoped>
.save-bar {
    position: sticky;
    bottom: 0;
    padding: 12px 0;
    background: #f8f9fc;
}
</style>
