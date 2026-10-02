<template>
    <div class="container pb-5">
        <h4 class="mb-1">Cài đặt chung</h4>
        <p class="text-muted small">Các thông tin lặt vặt hiển thị trên web. Để trống ô nào thì phần đó sẽ bị ẩn.</p>

        <!-- Logo: upload là lưu ngay, không cần bấm "Lưu tất cả" -->
        <div class="card mb-4" style="max-width: 760px">
            <div class="card-header font-weight-bold">Logo</div>
            <div class="card-body">
                <p class="text-muted small">Thay logo ở đây là thay cho toàn web. Ảnh PNG/JPG/WEBP, tối đa 2MB, nên dùng PNG nền trong suốt.</p>
                <div class="row">
                    <div class="col-md-6 mb-3" v-for="logo in logos" :key="logo.key">
                        <label class="font-weight-bold mb-1">{{ logo.label }}</label>
                        <small class="d-block text-muted mb-2">{{ logo.hint }}</small>
                        <div class="logo-preview" :style="{ background: logo.background }">
                            <img :src="logo.src()" alt="logo">
                        </div>
                        <div class="mt-2 d-flex align-items-center">
                            <label class="btn btn-sm btn-outline-primary mb-0">
                                {{ uploading === logo.key ? 'Đang tải...' : 'Chọn ảnh mới' }}
                                <input type="file" accept="image/png,image/jpeg,image/webp" hidden
                                       :disabled="uploading" @change="onLogoChange(logo.key, $event)">
                            </label>
                            <button v-if="settingsAll[logo.key]" type="button" class="btn btn-sm btn-link text-danger"
                                    @click="resetLogo(logo.key)">Dùng logo mặc định</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
            uploading: null,
            logos: [
                {
                    key: 'logo_main',
                    label: 'Logo chính (màu)',
                    hint: 'Dùng trên nền sáng: footer, trang đăng nhập, bài viết, icon tab trình duyệt.',
                    background: '#ffffff',
                    src: () => this.logoMain,
                },
                {
                    key: 'logo_white',
                    label: 'Logo trắng',
                    hint: 'Dùng trên nền đỏ: header, sidebar admin. Để trống thì dùng logo chính.',
                    background: '#B21818',
                    src: () => this.logoWhite,
                },
            ],
        }
    },
    computed: {
        ...mapGetters('settings', ['settingsAll', 'logoMain', 'logoWhite']),
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
        ...mapActions('settings', ['fetchSettings', 'updateSettings', 'uploadLogo', 'deleteLogo']),
        async onLogoChange(key, event) {
            const file = event.target.files[0];
            event.target.value = '';
            if (!file) return;
            this.uploading = key;
            await this.uploadLogo({key, file, toast: this.$toast});
            this.uploading = null;
        },
        async resetLogo(key) {
            if (confirm('Xóa logo đã tải lên và dùng lại logo mặc định?')) {
                await this.deleteLogo({key, toast: this.$toast});
            }
        },
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
.logo-preview {
    height: 120px;
    border: 1px solid #e3e6f0;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
}
.logo-preview img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}
.save-bar {
    position: sticky;
    bottom: 0;
    padding: 12px 0;
    background: #f8f9fc;
}
</style>
