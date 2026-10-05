<template>
    <div class="post-editor" :class="{'panel-open': panelOpen, 'panel-docked': panelDocked}">
        <!-- Thanh trên cùng -->
        <header class="pe-topbar">
            <div class="pe-topbar__left">
                <router-link :to="{name: 'Posts'}" class="pe-icon-btn" title="Về danh sách bài viết">
                    <i class="fas fa-arrow-left"></i>
                </router-link>
                <div class="pe-topbar__info">
                    <div class="pe-topbar__title">{{ isCreate ? "Bài viết mới" : "Chỉnh sửa bài viết" }}</div>
                    <div class="pe-status" :class="statusInfo.type">
                        <span class="pe-status__dot"></span>
                        <span>{{ statusInfo.text }}</span>
                        <span class="pe-status__sep">·</span>
                        <span class="pe-stats">{{ contentInfo.words }} từ · {{ contentInfo.minutes }} phút đọc · {{ contentInfo.headings }} mục</span>
                    </div>
                </div>
            </div>
            <div class="pe-topbar__actions">
                <button type="button" class="pe-chip" :class="checklistScore.type" title="Kiểm tra bài viết"
                        @click="openPanel">
                    <i class="fas fa-clipboard-check"></i>
                    <span>{{ checklistScore.passed }}/{{ checklist.length }}</span>
                </button>
                <button type="button" class="pe-icon-btn d-none d-md-inline-flex" title="Xem trước" @click="openPreview">
                    <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="pe-icon-btn" :class="{active: panelOpen}" title="Cài đặt bài viết"
                        @click="togglePanel">
                    <i class="fas fa-sliders-h"></i>
                </button>
                <button type="button" class="btn pe-btn-save" :disabled="saving || uploadingThumb" @click="save">
                    <span v-if="saving" class="spinner-border spinner-border-sm mr-1" role="status"></span>
                    {{ isCreate ? "Đăng bài" : "Cập nhật" }}
                </button>
            </div>
        </header>

        <div class="pe-body">
            <!-- Vùng viết -->
            <div class="pe-canvas">
                <div class="pe-canvas__inner">
                    <div v-if="pendingDraft" class="pe-alert pe-alert--warning">
                        <span>
                            <i class="fas fa-history mr-1"></i>
                            Có bản nháp chưa lưu lúc <b>{{ formatTime(pendingDraft.savedAt, true) }}</b>. Khôi phục?
                        </span>
                        <span class="pe-alert__actions">
                            <button type="button" class="btn btn-sm btn-warning" @click="restoreDraft">Khôi phục</button>
                            <button type="button" class="btn btn-sm btn-light" @click="discardDraft">Bỏ qua</button>
                        </span>
                    </div>
                    <div v-if="globalError" class="pe-alert pe-alert--danger" role="alert">
                        <span><i class="fas fa-exclamation-circle mr-1"></i>{{ globalError }}</span>
                        <button v-if="hasPanelErrors" type="button" class="btn btn-sm btn-light" @click="openPanel">
                            Xem trong Cài đặt
                        </button>
                    </div>

                    <article class="pe-sheet">
                        <textarea id="inputTitle" ref="titleInput" v-model="form.title" rows="1" class="pe-title-input"
                                  :class="{'is-invalid': errors.title}" placeholder="Tiêu đề bài viết"
                                  @input="autoGrowTitle" @keydown.enter.prevent="focusEditor"></textarea>
                        <div v-if="errors.title" class="pe-error">{{ errors.title }}</div>

                        <div class="pe-permalink">
                            <i class="fas fa-link"></i>
                            <span class="pe-permalink__base">{{ siteHost }}/blogs/</span>
                            <template v-if="editingSlug">
                                <input id="inputSlug" ref="slugInput" v-model="form.slug" class="pe-permalink__input"
                                       :class="{'is-invalid': errors.slug}" placeholder="duong-dan-bai-viet"
                                       @input="slugTouched = true" @keydown.enter.prevent="finishSlugEdit"
                                       @blur="finishSlugEdit">
                                <button type="button" class="pe-link-btn" @mousedown.prevent="finishSlugEdit">Xong</button>
                            </template>
                            <template v-else>
                                <span class="pe-permalink__slug">{{ form.slug || 'duong-dan-bai-viet' }}</span>
                                <button type="button" class="pe-link-btn" @click="startSlugEdit">Sửa</button>
                                <button v-if="form.title" type="button" class="pe-link-btn" title="Tạo lại từ tiêu đề"
                                        @click="regenerateSlug">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </template>
                        </div>
                        <div v-if="errors.slug" class="pe-error">{{ errors.slug }}</div>

                        <section v-show="form.subContent" class="pe-university">
                            <div class="pe-university__head">
                                <span><i class="fas fa-university"></i> Khung thông tin trường</span>
                                <button type="button" class="pe-link-btn text-danger" @click="form.subContent = false">Bỏ khung này</button>
                            </div>
                            <textarea ref="universityEditor"></textarea>
                        </section>

                        <div class="pe-content" :class="{'is-invalid': errors.content}">
                            <textarea ref="contentEditor"></textarea>
                        </div>
                        <div v-if="errors.content" class="pe-error">{{ errors.content }}</div>
                    </article>

                    <p class="pe-help">
                        <i class="fas fa-lightbulb"></i>
                        Chọn <b>Tiêu đề 1–4</b> ở ô "Đoạn văn" để chia mục (mục lục tự tạo) · Nút <b>Chèn khối</b> để thêm hộp lưu ý, nút tư vấn ·
                        Dán từ Word/Google Docs thoải mái, định dạng tự được chuẩn hóa
                    </p>
                </div>
            </div>

            <!-- Bảng cài đặt -->
            <div v-if="panelOpen && !panelDocked" class="pe-backdrop" @click="panelOpen = false"></div>
            <aside class="pe-panel" :aria-hidden="!panelOpen">
                <div class="pe-panel__head">
                    <span>Cài đặt bài viết</span>
                    <button type="button" class="pe-icon-btn pe-icon-btn--sm" title="Đóng" @click="panelOpen = false">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <section class="pe-section">
                    <div class="pe-section__head">
                        <h3><i class="fas fa-clipboard-check"></i> Kiểm tra bài viết</h3>
                        <span class="pe-score" :class="checklistScore.type">{{ checklistScore.passed }}/{{ checklist.length }}</span>
                    </div>
                    <div class="pe-score-bar"><div :class="checklistScore.type" :style="{width: checklistScore.percent + '%'}"></div></div>
                    <ul class="pe-checklist">
                        <li v-for="item in checklist" :key="item.key" :class="item.status">
                            <i class="fas" :class="item.status === 'good' ? 'fa-check-circle' : (item.status === 'warn' ? 'fa-exclamation-circle' : 'fa-times-circle')"></i>
                            <span>{{ item.text }}</span>
                        </li>
                    </ul>
                </section>

                <section class="pe-section">
                    <div class="pe-section__head">
                        <h3><i class="fas fa-image"></i> Ảnh đại diện</h3>
                        <label v-if="thumbPreview" for="imageInput" class="pe-link-btn mb-0">Đổi ảnh</label>
                    </div>
                    <input hidden type="file" id="imageInput" ref="imageInput" accept="image/*"
                           @change="onThumbnailSelected">
                    <label for="imageInput" class="pe-thumb mb-0"
                           :class="{'is-invalid': errors.thumbnail, dragging: dragging, 'has-image': thumbPreview}"
                           @dragover.prevent="dragging = true" @dragleave.prevent="dragging = false"
                           @drop.prevent="onThumbnailDrop">
                        <img v-if="thumbPreview" :src="thumbPreview" alt="Ảnh đại diện">
                        <span v-else class="pe-thumb__empty">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <b>Bấm hoặc kéo thả ảnh vào đây</b>
                            <small>Khuyến nghị 1200×675px (16:9), tối đa 5MB</small>
                        </span>
                        <span v-if="uploadingThumb" class="pe-thumb__overlay">
                            <span class="spinner-border text-light" role="status"></span>
                            <span class="mt-2">Đang tải ảnh... {{ uploadProgress }}%</span>
                        </span>
                    </label>
                    <div v-if="errors.thumbnail" class="pe-error">{{ errors.thumbnail }}</div>
                </section>

                <section class="pe-section">
                    <div class="pe-section__head">
                        <h3><i class="fas fa-folder-open"></i> Danh mục</h3>
                    </div>
                    <Multiselect v-model="form.categoryIds"
                                 mode="tags"
                                 :close-on-select="false"
                                 :searchable="true"
                                 :options="categoryOptions"
                                 placeholder="Chọn danh mục"
                                 no-options-text="Chưa có danh mục"
                                 no-results-text="Không tìm thấy danh mục"/>
                    <div v-if="errors.category" class="pe-error">{{ errors.category }}</div>
                </section>

                <section class="pe-section">
                    <div class="pe-section__head">
                        <h3><i class="fas fa-align-left"></i> Mô tả ngắn</h3>
                        <small :class="descriptionCounterClass">{{ descriptionLength }}/160</small>
                    </div>
                    <textarea id="inputDescription" v-model="form.description" rows="4" class="form-control pe-textarea"
                              :class="{'is-invalid': errors.description}"
                              placeholder="Tóm tắt bài viết trong 1–2 câu. Hiển thị dưới tiêu đề, ở danh sách bài và khi chia sẻ."></textarea>
                    <div v-if="errors.description" class="pe-error">{{ errors.description }}</div>
                    <div class="pe-serp">
                        <div class="pe-serp__label"><i class="fab fa-google"></i> Xem trước trên Google</div>
                        <div class="pe-serp__url">{{ siteHost }} › blogs › {{ form.slug || '...' }}</div>
                        <div class="pe-serp__title">{{ truncate(form.title || 'Tiêu đề bài viết', 60) }}</div>
                        <div class="pe-serp__desc">{{ truncate(form.description || 'Mô tả ngắn của bài viết sẽ hiển thị ở đây.', 160) }}</div>
                    </div>
                </section>

                <section class="pe-section">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="university" v-model="form.subContent">
                        <label class="custom-control-label" for="university">
                            <b>Khung thông tin trường</b>
                            <small class="d-block text-muted">Bảng thông tin trường hiển thị trước nội dung bài</small>
                        </label>
                    </div>
                </section>

                <div class="pe-panel__footer d-md-none">
                    <button type="button" class="btn btn-outline-primary btn-block" @click="openPreview">
                        <i class="fas fa-eye mr-1"></i> Xem trước bài viết
                    </button>
                </div>
            </aside>
        </div>

        <!-- Xem trước -->
        <div class="modal fade" id="postPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header align-items-center">
                        <h5 class="modal-title">Xem trước bài viết</h5>
                        <div class="btn-group btn-group-sm ml-auto mr-3" role="group">
                            <button type="button" class="btn" :class="previewDevice === 'desktop' ? 'btn-primary' : 'btn-outline-primary'"
                                    @click="previewDevice = 'desktop'"><i class="fas fa-desktop mr-1"></i> Máy tính</button>
                            <button type="button" class="btn" :class="previewDevice === 'mobile' ? 'btn-primary' : 'btn-outline-primary'"
                                    @click="previewDevice = 'mobile'"><i class="fas fa-mobile-alt mr-1"></i> Điện thoại</button>
                        </div>
                        <button type="button" class="close ml-0" aria-label="Close" @click="closePreview">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pe-preview-body">
                        <div v-if="preview" class="pe-preview" :class="`pe-preview--${previewDevice}`">
                            <div class="pe-preview__hero">
                                <div class="pe-preview__cats">
                                    <span v-for="item in selectedCategories" :key="item.id">{{ item.name }}</span>
                                </div>
                                <h1>{{ preview.title || '(Chưa có tiêu đề)' }}</h1>
                                <p v-if="preview.description">{{ preview.description }}</p>
                            </div>
                            <img v-if="preview.thumbnail" :src="preview.thumbnail" class="pe-preview__cover" alt="">
                            <PostArticle compact :content="preview.content"
                                         :university-info="preview.universityInfo"></PostArticle>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {markRaw} from 'vue';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import {mapGetters, mapActions} from "vuex";
import api from '@/utils/axios.js';
import {slugify} from '@/utils/slugify.js';
import {UNIVERSITY_TEMPLATE} from '@/utils/universityTemplate.js';
import PostArticle from '@/components/PostArticle.vue';
import {POST_BLOCKS} from '@/utils/postBlocks.js';
import postContentCssUrl from '../../../css/post-content.css?url';

const UPLOAD_URL = '/upload-image';
const DRAFT_PREFIX = 'post-draft:';
const PANEL_PREF_KEY = 'post-editor:panel-open';
// Từ độ rộng này bảng cài đặt được ghim bên phải thay vì trượt đè lên vùng viết
const PANEL_DOCK_MIN_WIDTH = 1500;
const SLUG_RE = /^[a-z0-9đ]+(?:-[a-z0-9đ]+)*$/;
const FONTS_CSS_URL = 'https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap';

// Bảng màu chữ / màu nền được phép dùng trong bài (giữ bài viết đồng bộ thương hiệu)
const TEXT_COLORS = [
    'B21818', 'Đỏ thương hiệu',
    '1B1F23', 'Đen',
    '4B5563', 'Xám đậm',
    '2F6FEC', 'Xanh dương',
    '1F9D55', 'Xanh lá',
    'E8930C', 'Cam',
];
const HIGHLIGHT_COLORS = [
    'FFF3BF', 'Vàng nhạt',
    'FDE2E2', 'Đỏ nhạt',
    'DCFCE7', 'Xanh lá nhạt',
    'DBEAFE', 'Xanh dương nhạt',
];

function isBlankElement(el) {
    return !el.textContent.replace(/[\s\p{Cf}]/gu, '') && !el.querySelector('img, iframe, video, table, hr');
}

const emptyForm = () => ({
    title: '',
    slug: '',
    description: '',
    thumbnail: '',
    categoryIds: [],
    subContent: false,
    contentUniversity: UNIVERSITY_TEMPLATE,
    content: '',
});

// Upload một ảnh lên server, trả về URL
async function uploadImage(file, onProgress) {
    const formData = new FormData();
    formData.append('upload', file);
    const response = await api.post(UPLOAD_URL, formData, {
        timeout: 60000,
        onUploadProgress: (e) => {
            if (onProgress && e.total) onProgress(Math.round((e.loaded / e.total) * 100));
        },
    });
    return response.data.url;
}

function uploadErrorMessage(error) {
    return error?.response?.data?.error?.message || 'Tải ảnh thất bại, vui lòng thử lại.';
}

function storage(action, key, value) {
    try {
        if (action === 'get') return JSON.parse(localStorage.getItem(key) || 'null');
        if (action === 'set') localStorage.setItem(key, JSON.stringify(value));
        if (action === 'remove') localStorage.removeItem(key);
    } catch (e) {
        return null;
    }
}

export default {
    name: "PostsAdd",
    components: {
        Multiselect,
        PostArticle,
    },
    data() {
        return {
            form: emptyForm(),
            baseline: '',
            slugTouched: false,
            routeSlug: this.$route.params.postsId || null,
            loaded: !this.$route.params.postsId,
            errors: {},
            globalError: '',
            saving: false,
            uploadingThumb: false,
            uploadProgress: 0,
            localThumbPreview: '',
            dragging: false,
            pendingDraft: null,
            draftSavedAt: null,
            preview: null,
            previewDevice: 'desktop',
            editingSlug: false,
            leaving: false,
            viewportWidth: window.innerWidth,
            panelOpen: false,
        };
    },
    computed: {
        ...mapGetters('category', ['categoryAll']),
        ...mapGetters('posts', ['posts']),
        isCreate() {
            return !this.routeSlug;
        },
        draftKey() {
            return DRAFT_PREFIX + (this.routeSlug || 'new');
        },
        snapshot() {
            // Khung thông tin trường chỉ tính khi đang bật
            const {contentUniversity, ...rest} = this.form;
            return JSON.stringify({...rest, contentUniversity: this.form.subContent ? contentUniversity : ''});
        },
        isDirty() {
            return this.loaded && this.snapshot !== this.baseline;
        },
        categoryOptions() {
            return (this.categoryAll || []).map(item => ({value: item.id, label: item.type_name}));
        },
        selectedCategories() {
            const byId = new Map((this.categoryAll || []).map(item => [item.id, item.type_name]));
            return this.form.categoryIds
                .filter(id => byId.has(id))
                .map(id => ({id, name: byId.get(id)}));
        },
        thumbPreview() {
            return this.localThumbPreview || this.form.thumbnail;
        },
        descriptionLength() {
            return (this.form.description || '').length;
        },
        panelDocked() {
            return this.viewportWidth >= PANEL_DOCK_MIN_WIDTH;
        },
        hasPanelErrors() {
            return !!(this.errors.thumbnail || this.errors.category || this.errors.description);
        },
        siteHost() {
            return window.location.host;
        },
        statusInfo() {
            if (this.saving) return {type: 'saving', text: 'Đang lưu bài viết...'};
            if (this.isDirty && this.draftSavedAt) return {type: 'dirty', text: `Chưa đăng · nháp tạm lưu lúc ${this.formatTime(this.draftSavedAt)}`};
            if (this.isDirty) return {type: 'dirty', text: 'Có thay đổi chưa lưu'};
            if (!this.isCreate) return {type: 'saved', text: 'Đã lưu, không có thay đổi'};
            return {type: '', text: 'Bài viết mới'};
        },
        // Phân tích nội dung bài: số từ, số tiêu đề, ảnh thiếu mô tả...
        contentInfo() {
            const doc = new DOMParser().parseFromString(this.form.content || '', 'text/html');
            const text = (doc.body.textContent || '').trim();
            const words = text ? text.split(/\s+/).length : 0;
            const images = Array.from(doc.querySelectorAll('img'));
            return {
                words,
                minutes: Math.max(1, Math.round(words / 200)),
                headings: doc.querySelectorAll('h1, h2, h3, h4').length,
                images: images.length,
                imagesNoAlt: images.filter(img => !(img.getAttribute('alt') || '').trim()).length,
            };
        },
        checklist() {
            const f = this.form;
            const titleLen = f.title.trim().length;
            const descLen = this.descriptionLength;
            const info = this.contentInfo;
            const item = (key, status, text) => ({key, status, text});
            return [
                !titleLen ? item('title', 'bad', 'Chưa có tiêu đề')
                    : titleLen < 30 ? item('title', 'warn', `Tiêu đề hơi ngắn (${titleLen} ký tự), nên 30–70 ký tự`)
                    : titleLen > 70 ? item('title', 'warn', `Tiêu đề hơi dài (${titleLen} ký tự), Google sẽ cắt bớt sau ~70 ký tự`)
                    : item('title', 'good', `Tiêu đề dài vừa đủ (${titleLen} ký tự)`),
                !descLen ? item('desc', 'bad', 'Chưa có mô tả ngắn')
                    : descLen < 80 ? item('desc', 'warn', `Mô tả hơi ngắn (${descLen} ký tự), nên 120–160 ký tự`)
                    : descLen > 160 ? item('desc', 'warn', `Mô tả hơi dài (${descLen} ký tự), Google sẽ cắt bớt sau 160 ký tự`)
                    : item('desc', 'good', `Mô tả dài vừa đủ (${descLen} ký tự)`),
                f.thumbnail ? item('thumb', 'good', 'Đã có ảnh đại diện') : item('thumb', 'bad', 'Chưa có ảnh đại diện'),
                f.categoryIds.length ? item('cat', 'good', 'Đã chọn danh mục') : item('cat', 'bad', 'Chưa chọn danh mục'),
                info.words >= 300 ? item('words', 'good', `Độ dài tốt (${info.words} từ)`)
                    : item('words', info.words ? 'warn' : 'bad', `Bài khá ngắn (${info.words} từ), nên viết từ 300 từ trở lên`),
                info.headings >= 2 ? item('toc', 'good', `Có ${info.headings} tiêu đề mục, mục lục sẽ tự tạo`)
                    : item('toc', 'warn', 'Nên chia bài thành ít nhất 2 mục bằng Tiêu đề để có mục lục'),
                !info.images ? item('img', 'warn', 'Nên thêm ít nhất 1 ảnh minh họa trong bài')
                    : info.imagesNoAlt ? item('img', 'warn', `${info.imagesNoAlt} ảnh chưa có mô tả (alt). Bấm vào ảnh → nút Ảnh để thêm`)
                    : item('img', 'good', `${info.images} ảnh đều đã có mô tả`),
            ];
        },
        checklistScore() {
            const passed = this.checklist.filter(item => item.status === 'good').length;
            const percent = Math.round((passed / this.checklist.length) * 100);
            return {passed, percent, type: percent >= 85 ? 'good' : (percent >= 50 ? 'warn' : 'bad')};
        },
        descriptionCounterClass() {
            const len = this.descriptionLength;
            if (len > 160) return 'text-warning';
            if (len >= 120) return 'text-success';
            return 'text-muted';
        },
    },
    watch: {
        'form.title'(title) {
            // Bài mới: slug tự chạy theo tiêu đề cho đến khi người dùng tự sửa slug
            if (this.isCreate && !this.slugTouched) {
                this.form.slug = slugify(title);
            }
            this.$nextTick(this.autoGrowTitle);
        },
        'form.subContent'(on) {
            if (on && !this.form.contentUniversity) {
                this.form.contentUniversity = UNIVERSITY_TEMPLATE;
                this.setEditorContent('contentUniversity');
            }
            if (on) this.$nextTick(this.ensureUniversityEditor);
        },
        snapshot() {
            if (this.isDirty) {
                this.scheduleDraftSave();
            }
        },
        posts(newValue) {
            if (!this.isCreate && newValue?.data && newValue.data.slug === this.routeSlug) {
                this.fillForm(newValue.data);
            }
        },
    },
    created() {
        this.editors = {};
        this.draftTimer = null;
        this.syncTimers = {};
        this.fetchCategory();
        this.baseline = this.snapshot;

        if (this.isCreate) {
            this.checkDraft(null);
        } else {
            this.clearPost();
            this.getOnePost(this.routeSlug);
        }
    },
    mounted() {
        this.initEditor('content', this.$refs.contentEditor);
        window.addEventListener('beforeunload', this.onBeforeUnload);
        window.addEventListener('resize', this.onResize);
        this.autoGrowTitle();
        this.enterWritingMode();
        const pref = storage('get', PANEL_PREF_KEY);
        this.panelOpen = this.panelDocked && pref !== false;
    },
    beforeUnmount() {
        window.removeEventListener('beforeunload', this.onBeforeUnload);
        window.removeEventListener('resize', this.onResize);
        this.exitWritingMode();
        clearTimeout(this.draftTimer);
        this.syncAllEditors();
        if (this.isDirty && !this.leaving) this.saveDraftNow();
        Object.values(this.syncTimers).forEach(clearTimeout);
        Object.values(this.editors).forEach(editor => editor.remove());
        this.editors = {};
        this.closePreview();
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    },
    beforeRouteLeave(to, from, next) {
        if (this.isDirty && !this.leaving) {
            const ok = window.confirm('Bài viết có thay đổi chưa lưu (bản nháp tạm vẫn được giữ trên trình duyệt này). Bạn có chắc muốn rời trang?');
            if (!ok) return next(false);
        }
        next();
    },
    methods: {
        ...mapActions('category', ['fetchCategory']),
        ...mapActions('posts', ['addPost', 'getOnePost', 'updatePost', 'clearPost']),
        slugify,

        // ---------- Trình soạn thảo ----------
        initEditor(field, target) {
            const isContent = field === 'content';
            // Riêng editor nội dung bài dùng chung CSS với trang bài viết để soạn thấy sao lên web y vậy
            const contentOptions = isContent ? {
                content_css: [FONTS_CSS_URL, postContentCssUrl],
                body_class: 'post-content',
                content_style: 'body.post-content { max-width: none; margin: 0; padding: 24px 0 40px !important; } .mce-content-body[data-mce-placeholder]:not(.mce-visualblocks)::before { left: 0; color: #b0b5bf; font-style: normal; }',
                placeholder: 'Bắt đầu viết nội dung bài viết...',
                menubar: false,
                statusbar: false,
                // Bỏ font, cỡ chữ, giãn dòng lộn xộn khi dán từ Word/Google Docs
                invalid_styles: {'*': 'font-family font-size line-height letter-spacing text-indent'},
                plugins: 'advlist anchor autolink autoresize charmap code emoticons fullscreen image link lists media searchreplace table visualblocks wordcount quickbars accordion',
                toolbar: 'blocks | bold italic | insertblock | bullist numlist | link image table | blockquote forecolor backcolor underline | alignleft aligncenter alignright | media removeformat | undo redo | code fullscreen',
                toolbar_mode: 'sliding',
                // Điện thoại: thanh công cụ vuốt ngang để thấy đủ nút
                mobile: {toolbar_mode: 'scrolling'},
                min_height: 560,
                autoresize_bottom_margin: 40,
                paste_postprocess: (editor, args) => {
                    args.node.querySelectorAll('p, div:not([class])').forEach(el => {
                        if (isBlankElement(el)) el.remove();
                    });
                },
                setupExtra: (editor) => {
                    editor.ui.registry.addMenuButton('insertblock', {
                        text: 'Chèn khối',
                        icon: 'template',
                        tooltip: 'Chèn hộp lưu ý, nút tư vấn, bảng mẫu...',
                        fetch: (callback) => callback(POST_BLOCKS.map(block => ({
                            type: 'menuitem',
                            text: block.text,
                            icon: block.icon,
                            onAction: () => editor.insertContent(block.html),
                        }))),
                    });
                },
            } : {
                content_style: 'body { font-family: Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.6; } img { max-width: 100%; height: auto; }',
                plugins: 'advlist autolink charmap code image link lists table',
                toolbar: 'undo redo | bold italic underline forecolor | link image table | removeformat code',
                menubar: false,
                height: 420,
                // Khung ngắn, không cần thanh công cụ dính (dính khi đang ẩn sẽ bị lệch vị trí)
                toolbar_sticky: false,
            };
            const {setupExtra, ...options} = contentOptions;

            tinymce.init({
                target,
                license_key: 'gpl',
                language: 'vi',
                // Lưu chữ tiếng Việt nguyên dạng thay vì &aacute;...
                entity_encoding: 'raw',
                promotion: false,
                branding: false,
                menubar: 'edit view insert format table tools',
                toolbar_mode: 'wrap',
                toolbar_sticky: true,
                toolbar_sticky_offset: 64, // chiều cao .pe-topbar
                block_formats: 'Đoạn văn=p; Tiêu đề 1=h1; Tiêu đề 2=h2; Tiêu đề 3=h3; Tiêu đề 4=h4; Trích dẫn=blockquote',
                quickbars_insert_toolbar: false,
                quickbars_selection_toolbar: 'bold italic underline | blocks | forecolor | quicklink blockquote',
                color_map_foreground: TEXT_COLORS,
                color_map_background: HIGHLIGHT_COLORS,
                custom_colors: false,
                table_default_attributes: {},
                table_default_styles: {width: '100%'},
                table_class_list: [
                    {title: 'Có hàng tiêu đề', value: ''},
                    {title: 'Không có hàng tiêu đề', value: 'no-header'},
                ],
                // Giữ nguyên đường dẫn ảnh dạng /storage/..., không đổi thành ../../storage
                relative_urls: false,
                convert_urls: false,
                image_title: true,
                image_caption: true,
                image_dimensions: false,
                // Ảnh dán/kéo vào bài được upload một lần khi bấm Lưu (uploadEditorImages)
                automatic_uploads: false,
                paste_data_images: true,
                file_picker_types: 'image',
                images_upload_handler: (blobInfo, progress) =>
                    uploadImage(blobInfo.blob(), progress).catch(error => {
                        throw {message: uploadErrorMessage(error), remove: true};
                    }),
                file_picker_callback: (callback) => {
                    const input = document.createElement('input');
                    input.type = 'file';
                    input.accept = 'image/*';
                    input.addEventListener('change', async () => {
                        const file = input.files[0];
                        if (!file) return;
                        try {
                            callback(await uploadImage(file), {title: file.name});
                        } catch (error) {
                            this.toast(uploadErrorMessage(error), 'error');
                        }
                    });
                    input.click();
                },
                ...options,
                setup: (editor) => {
                    if (setupExtra) setupExtra(editor);
                    editor.on('init', () => {
                        this.editors[field] = markRaw(editor);
                        const wasClean = !this.isDirty;
                        this.setEditorContent(field);
                        if (wasClean) this.markClean();
                    });
                    editor.on('input change undo redo ExecCommand', () => this.queueEditorSync(field));
                },
            });
        },
        // Đưa nội dung từ form vào editor rồi đọc lại (TinyMCE có thể chuẩn hóa HTML)
        setEditorContent(field) {
            const editor = this.editors[field];
            if (!editor) return;
            editor.setContent(this.form[field] || '');
            if (field === 'content') {
                // Bỏ các đoạn trống thừa (thường do dán từ Word)
                editor.getBody().querySelectorAll(':scope > p, :scope > div:not([class])').forEach(el => {
                    if (isBlankElement(el)) el.remove();
                });
            }
            this.form[field] = editor.getContent();
        },
        queueEditorSync(field) {
            clearTimeout(this.syncTimers[field]);
            this.syncTimers[field] = setTimeout(() => this.syncEditor(field), 300);
        },
        syncEditor(field) {
            const editor = this.editors[field];
            if (editor) this.form[field] = editor.getContent();
        },
        syncAllEditors() {
            Object.keys(this.editors).forEach(this.syncEditor);
        },
        // Upload các ảnh dán vào editor (base64/blob) lên server và thay bằng URL thật
        async uploadEditorImages() {
            const fields = ['content'];
            if (this.form.subContent) fields.push('contentUniversity');
            for (const field of fields) {
                const editor = this.editors[field];
                if (!editor) continue;
                const results = await editor.uploadImages();
                if (results.some(result => !result.status)) {
                    throw new Error('Có ảnh trong bài tải lên thất bại, vui lòng thử lại.');
                }
            }
            this.syncAllEditors();
        },

        // ---------- Dữ liệu bài viết ----------
        fillForm(data) {
            let categoryIds = [];
            try {
                categoryIds = JSON.parse(data.post_type_id || '[]').map(item => item.id);
            } catch (e) {
                console.error('Invalid post_type_id', e);
            }
            const subContent = [1, '1', true, 'true'].includes(data.type);
            this.form = {
                title: data.title || '',
                slug: data.slug || '',
                description: data.description || '',
                thumbnail: data.thumbnail || '',
                categoryIds,
                subContent,
                contentUniversity: subContent && data.university_info ? data.university_info : UNIVERSITY_TEMPLATE,
                content: data.content || '',
            };
            this.slugTouched = true;
            this.setEditorContent('content');
            this.setEditorContent('contentUniversity');
            this.loaded = true;
            this.markClean();
            this.checkDraft(data.updated_at);
        },
        markClean() {
            this.baseline = this.snapshot;
        },
        regenerateSlug() {
            this.form.slug = slugify(this.form.title);
            delete this.errors.slug;
        },
        // Vào trang viết: thu gọn menu admin để vùng viết rộng hơn; rời trang thì trả lại như cũ
        // Editor khung thông tin trường chỉ tạo khi khung được bật, vì tạo lúc đang ẩn (rộng = 0)
        // thì thanh công cụ của TinyMCE bị dựng sai kích thước và vị trí
        ensureUniversityEditor() {
            if (this.universityEditorStarted || !this.form.subContent || !this.$refs.universityEditor) return;
            this.universityEditorStarted = true;
            this.initEditor('contentUniversity', this.$refs.universityEditor);
        },
        enterWritingMode() {
            const sidebar = document.getElementById('accordionSidebar');
            this.sidebarWasToggled = sidebar ? sidebar.classList.contains('toggled') : true;
            sidebar?.classList.add('toggled');
            document.body.classList.add('sidebar-toggled', 'post-editor-mode');
        },
        exitWritingMode() {
            document.body.classList.remove('post-editor-mode');
            if (!this.sidebarWasToggled) {
                document.getElementById('accordionSidebar')?.classList.remove('toggled');
                document.body.classList.remove('sidebar-toggled');
            }
        },
        onResize() {
            this.viewportWidth = window.innerWidth;
        },
        togglePanel() {
            this.panelOpen = !this.panelOpen;
            if (this.panelDocked) storage('set', PANEL_PREF_KEY, this.panelOpen);
        },
        openPanel() {
            this.panelOpen = true;
        },
        focusEditor() {
            this.editors.content?.focus();
        },
        startSlugEdit() {
            this.editingSlug = true;
            this.$nextTick(() => this.$refs.slugInput?.focus());
        },
        finishSlugEdit() {
            this.form.slug = slugify(this.form.slug);
            this.editingSlug = false;
        },
        autoGrowTitle() {
            const el = this.$refs.titleInput;
            if (!el) return;
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
        },
        truncate(text, max) {
            return text.length > max ? text.slice(0, max - 1).trimEnd() + '…' : text;
        },

        // ---------- Ảnh thumbnail ----------
        onThumbnailSelected(event) {
            this.uploadThumbnail(event.target.files[0]);
            event.target.value = '';
        },
        onThumbnailDrop(event) {
            this.dragging = false;
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) this.uploadThumbnail(file);
        },
        async uploadThumbnail(file) {
            if (!file) return;
            this.localThumbPreview = URL.createObjectURL(file);
            this.uploadingThumb = true;
            this.uploadProgress = 0;
            try {
                this.form.thumbnail = await uploadImage(file, p => this.uploadProgress = p);
                delete this.errors.thumbnail;
            } catch (error) {
                this.toast(uploadErrorMessage(error), 'error');
            } finally {
                URL.revokeObjectURL(this.localThumbPreview);
                this.localThumbPreview = '';
                this.uploadingThumb = false;
            }
        },

        // ---------- Nháp tạm (localStorage) ----------
        checkDraft(updatedAt) {
            const draft = storage('get', this.draftKey);
            if (!draft || !draft.form) return;
            const serverTime = updatedAt ? Date.parse(updatedAt) : 0;
            if (draft.savedAt > serverTime) {
                this.pendingDraft = draft;
            } else {
                // Bài trên server mới hơn bản nháp -> bỏ nháp cũ
                storage('remove', this.draftKey);
            }
        },
        scheduleDraftSave() {
            clearTimeout(this.draftTimer);
            this.draftTimer = setTimeout(this.saveDraftNow, 1500);
        },
        saveDraftNow() {
            if (!this.isDirty) return;
            const savedAt = Date.now();
            storage('set', this.draftKey, {form: this.form, savedAt});
            this.draftSavedAt = savedAt;
        },
        restoreDraft() {
            this.form = {...emptyForm(), ...this.pendingDraft.form};
            this.slugTouched = true;
            this.setEditorContent('content');
            this.setEditorContent('contentUniversity');
            this.draftSavedAt = this.pendingDraft.savedAt;
            this.pendingDraft = null;
        },
        discardDraft() {
            storage('remove', this.draftKey);
            this.pendingDraft = null;
        },

        // ---------- Lưu ----------
        validateForm() {
            const errors = {};
            const f = this.form;
            if (!f.title.trim()) errors.title = "Vui lòng nhập tiêu đề.";
            if (!f.slug) {
                errors.slug = "Vui lòng nhập slug.";
            } else if (!SLUG_RE.test(f.slug)) {
                errors.slug = "Slug không hợp lệ. Chỉ chấp nhận chữ thường, số và dấu gạch ngang.";
            }
            if (!f.categoryIds.length) errors.category = "Vui lòng chọn danh mục.";
            if (!(f.description || '').trim()) errors.description = "Vui lòng nhập mô tả.";
            const hasContent = f.content.replace(/<[^>]*>|&nbsp;/g, '').trim() || /<(img|iframe|video|table)/i.test(f.content);
            if (!hasContent) errors.content = "Vui lòng nhập nội dung.";
            if (!f.thumbnail) errors.thumbnail = "Vui lòng chọn ảnh đại diện.";
            this.errors = errors;
            return Object.keys(errors).length === 0;
        },
        async save() {
            this.syncAllEditors();
            this.form.slug = slugify(this.form.slug) || this.form.slug;
            if (this.uploadingThumb) {
                this.globalError = "Ảnh đại diện đang được tải lên, vui lòng đợi trong giây lát.";
                return;
            }
            if (!this.validateForm()) {
                if (this.errors.slug) this.editingSlug = true;
                if (this.hasPanelErrors) this.panelOpen = true;
                this.globalError = "Vui lòng điền đầy đủ thông tin.";
                window.scrollTo({top: 0, behavior: 'smooth'});
                return;
            }
            this.globalError = '';
            this.saving = true;
            try {
                await this.uploadEditorImages();
            } catch (error) {
                this.saving = false;
                this.globalError = error.message;
                return;
            }
            const payload = {
                id: this.routeSlug,
                title: this.form.title.trim(),
                slug: this.form.slug,
                thumbnail: this.form.thumbnail,
                category: this.selectedCategories,
                description: this.form.description.trim(),
                content: this.form.content,
                type: this.form.subContent,
                contentUniversity: this.form.subContent ? this.form.contentUniversity : '',
            };
            const ok = this.isCreate
                ? await this.addPost({data: payload, toast: this.$toast})
                : await this.updatePost({data: payload, toast: this.$toast});
            this.saving = false;
            if (ok) {
                clearTimeout(this.draftTimer);
                storage('remove', this.draftKey);
                this.markClean();
                this.leaving = true;
                this.$router.push({name: 'Posts'});
            }
        },
        cancel() {
            this.$router.push({name: 'Posts'});
        },

        // ---------- Xem trước ----------
        openPreview() {
            this.syncAllEditors();
            this.preview = {
                title: this.form.title,
                description: this.form.description,
                thumbnail: this.thumbPreview,
                content: this.form.content,
                universityInfo: this.form.subContent ? this.form.contentUniversity : '',
            };
            $('#postPreviewModal').modal('show');
        },
        closePreview() {
            $('#postPreviewModal').modal('hide');
        },

        // ---------- Tiện ích ----------
        onBeforeUnload(event) {
            if (this.isDirty) {
                this.syncAllEditors();
                this.saveDraftNow();
                event.preventDefault();
                event.returnValue = '';
            }
        },
        formatTime(timestamp, withDate = false) {
            const date = new Date(timestamp);
            const time = date.toLocaleTimeString('vi-VN', {hour: '2-digit', minute: '2-digit'});
            return withDate ? `${time} ${date.toLocaleDateString('vi-VN')}` : time;
        },
        toast(message, type = 'success') {
            this.$toast.open({message, type, position: 'top'});
        },
    },
}
</script>

<style>
/* Chế độ viết bài: ẩn thanh trên của admin để dành chỗ cho vùng soạn thảo */
body.post-editor-mode #content > .topbar,
body.post-editor-mode #content-wrapper > .sticky-footer {
    display: none !important;
}
</style>

<style scoped>
.post-editor {
    --brand: #b21818;
    --pe-border: #e6e8ee;
    --pe-muted: #6b7280;
    --pe-text: #1f2937;
    --pe-topbar-h: 64px;
    --pe-panel-w: 360px;
    color: var(--pe-text);
    background: #f4f5f8;
    min-height: 100vh;
}

/* ---------- Thanh trên cùng ---------- */
.pe-topbar {
    position: sticky;
    top: 0;
    z-index: 1035;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    height: var(--pe-topbar-h);
    padding: 0 20px;
    background: #fff;
    border-bottom: 1px solid var(--pe-border);
}
.pe-topbar__left {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}
.pe-topbar__info {
    min-width: 0;
}
.pe-topbar__title {
    font-size: 16px;
    font-weight: 700;
    line-height: 1.2;
    color: var(--pe-text);
}
.pe-status {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    color: var(--pe-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pe-status__dot {
    flex-shrink: 0;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #9ca3af;
}
.pe-status.saved .pe-status__dot { background: #10b981; }
.pe-status.dirty .pe-status__dot { background: #f59e0b; }
.pe-status.saving .pe-status__dot { background: #3b82f6; animation: pe-pulse 1s infinite; }
@keyframes pe-pulse {
    50% { opacity: .3; }
}
.pe-status__sep {
    color: #d1d5db;
}
.pe-topbar__actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
.pe-icon-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    padding: 0;
    border: 1px solid transparent;
    border-radius: 10px;
    background: transparent;
    color: #4b5563;
    font-size: 16px;
    cursor: pointer;
    transition: all .15s;
}
.pe-icon-btn:hover {
    background: #f3f4f6;
    color: var(--pe-text);
    text-decoration: none;
}
.pe-icon-btn.active {
    background: #fdecec;
    color: var(--brand);
}
.pe-icon-btn--sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
}
.pe-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    height: 32px;
    padding: 0 12px;
    border: 0;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
}
.pe-chip.good { background: #dcfce7; color: #166534; }
.pe-chip.warn { background: #fef3c7; color: #92400e; }
.pe-chip.bad { background: #fee2e2; color: #991b1b; }
.pe-btn-save {
    height: 38px;
    padding: 0 18px;
    border-radius: 10px;
    background: var(--brand);
    color: #fff;
    font-weight: 700;
    box-shadow: 0 6px 16px -6px rgba(178, 24, 24, .6);
}
.pe-btn-save:hover,
.pe-btn-save:focus {
    background: #961313;
    color: #fff;
}

/* ---------- Bố cục ---------- */
.pe-body {
    display: flex;
    align-items: flex-start;
}
.pe-canvas {
    flex: 1;
    min-width: 0;
    padding: 32px 24px 60px;
}
.pe-canvas__inner {
    max-width: 900px;
    margin: 0 auto;
}

/* ---------- Trang giấy ---------- */
.pe-sheet {
    padding: 48px 64px 56px;
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 1px 3px rgba(15, 23, 42, .06), 0 12px 32px -18px rgba(15, 23, 42, .18);
}
.pe-title-input {
    display: block;
    width: 100%;
    padding: 0;
    border: 0;
    outline: none;
    resize: none;
    overflow: hidden;
    background: transparent;
    font-family: 'Montserrat', 'Open Sans', Arial, sans-serif;
    font-size: 36px;
    font-weight: 700;
    line-height: 1.25;
    letter-spacing: -0.02em;
    color: #111827;
}
.pe-title-input::placeholder {
    color: #c9ccd3;
}
.pe-title-input.is-invalid::placeholder {
    color: #f3a5a5;
}
.pe-permalink {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
    margin: 12px 0 0;
    padding-bottom: 20px;
    border-bottom: 1px solid #f0f1f4;
    font-size: 13px;
    color: #9ca3af;
}
.pe-permalink__slug {
    color: #4b5563;
    font-weight: 600;
    word-break: break-all;
}
.pe-permalink__input {
    flex: 1;
    min-width: 200px;
    padding: 4px 8px;
    border: 1px solid #93c5fd;
    border-radius: 6px;
    outline: none;
    font-size: 13px;
    color: var(--pe-text);
}
.pe-permalink__input.is-invalid {
    border-color: #dc2626;
}
.pe-link-btn {
    padding: 0;
    border: 0;
    background: none;
    color: #2563eb;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}
.pe-link-btn:hover {
    text-decoration: underline;
}
.pe-error {
    margin-top: 6px;
    color: #dc2626;
    font-size: 13px;
}

/* Khung thông tin trường */
.pe-university {
    margin-top: 24px;
    padding: 14px;
    border: 1px dashed #d1d5db;
    border-radius: 12px;
}
.pe-university__head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 13px;
    font-weight: 700;
    color: #4b5563;
}
.pe-university__head i {
    margin-right: 4px;
    color: var(--brand);
}

/* Trình soạn thảo liền mạch với trang giấy: bỏ viền, thanh công cụ dính dưới thanh trên cùng */
.pe-content {
    margin-top: 8px;
}
.pe-content :deep(.tox-tinymce) {
    border: 0;
    border-radius: 0;
}
.pe-content :deep(.tox .tox-editor-header) {
    margin: 0 -12px;
    padding: 4px 0;
    border-bottom: 1px solid #f0f1f4 !important;
    box-shadow: none !important;
}
.pe-content :deep(.tox .tox-toolbar),
.pe-content :deep(.tox .tox-toolbar__primary),
.pe-content :deep(.tox .tox-toolbar__overflow) {
    background: #fff !important;
}
.pe-content :deep(.tox-tinymce--toolbar-sticky-on .tox-editor-header) {
    border-radius: 0 0 10px 10px;
    box-shadow: 0 6px 16px -10px rgba(15, 23, 42, .25) !important;
}
.pe-content.is-invalid :deep(.tox-edit-area) {
    outline: 2px solid #fecaca;
    border-radius: 8px;
}
.pe-university :deep(.tox-tinymce) {
    border-radius: 8px;
    border-color: var(--pe-border);
}

.pe-help {
    margin: 14px 4px 0;
    font-size: 12.5px;
    line-height: 1.6;
    color: #9ca3af;
}
.pe-help i {
    margin-right: 4px;
    color: #f59e0b;
}

/* ---------- Thông báo ---------- */
.pe-alert {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 16px;
    padding: 12px 16px;
    border-radius: 12px;
    border: 1px solid;
    font-size: 14px;
}
.pe-alert--warning {
    background: #fffbeb;
    border-color: #fde68a;
    color: #92400e;
}
.pe-alert--danger {
    background: #fef2f2;
    border-color: #fecaca;
    color: #991b1b;
}
.pe-alert__actions {
    display: flex;
    gap: 6px;
}

/* ---------- Bảng cài đặt ---------- */
.pe-panel {
    width: var(--pe-panel-w);
    flex-shrink: 0;
    background: #fff;
    border-left: 1px solid var(--pe-border);
    overflow-y: auto;
    overscroll-behavior: contain;
}
/* Màn hình rộng: ghim bên phải, ẩn/hiện bằng nút Cài đặt */
.panel-docked .pe-panel {
    position: sticky;
    top: var(--pe-topbar-h);
    height: calc(100vh - var(--pe-topbar-h));
}
.panel-docked:not(.panel-open) .pe-panel {
    display: none;
}
/* Màn hình nhỏ hơn: trượt ra đè lên vùng viết (nằm dưới thanh trên cùng để vẫn bấm lưu được) */
.post-editor:not(.panel-docked) .pe-panel {
    position: fixed;
    top: var(--pe-topbar-h);
    right: 0;
    z-index: 1034;
    width: min(var(--pe-panel-w), 92vw);
    height: calc(100vh - var(--pe-topbar-h));
    box-shadow: -12px 0 32px rgba(15, 23, 42, .18);
    transform: translateX(105%);
    transition: transform .25s ease;
}
.post-editor:not(.panel-docked).panel-open .pe-panel {
    transform: translateX(0);
}
.pe-backdrop {
    position: fixed;
    inset: var(--pe-topbar-h) 0 0 0;
    z-index: 1033;
    background: rgba(15, 23, 42, .35);
}
.pe-panel__head {
    position: sticky;
    top: 0;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 56px;
    padding: 0 12px 0 20px;
    background: #fff;
    border-bottom: 1px solid var(--pe-border);
    font-weight: 700;
}
.pe-section {
    padding: 18px 20px;
    border-bottom: 1px solid #f0f1f4;
}
.pe-section__head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 12px;
}
.pe-section__head h3 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: var(--pe-text);
}
.pe-section__head h3 i {
    width: 18px;
    margin-right: 6px;
    color: var(--brand);
    text-align: center;
}
.pe-panel__footer {
    padding: 16px 20px 24px;
}

/* Kiểm tra bài viết */
.pe-score {
    padding: 2px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.pe-score.good { background: #dcfce7; color: #166534; }
.pe-score.warn { background: #fef3c7; color: #92400e; }
.pe-score.bad { background: #fee2e2; color: #991b1b; }
.pe-score-bar {
    height: 6px;
    margin-bottom: 10px;
    border-radius: 6px;
    background: #f1f5f9;
    overflow: hidden;
}
.pe-score-bar div {
    height: 100%;
    border-radius: 6px;
    transition: width .3s;
}
.pe-score-bar .good { background: #22c55e; }
.pe-score-bar .warn { background: #f59e0b; }
.pe-score-bar .bad { background: #ef4444; }
.pe-checklist {
    margin: 0;
    padding: 0;
    list-style: none;
}
.pe-checklist li {
    display: flex;
    gap: 8px;
    padding: 5px 0;
    font-size: 13px;
    line-height: 1.45;
    color: #374151;
}
.pe-checklist i {
    margin-top: 2px;
}
.pe-checklist .good i { color: #22c55e; }
.pe-checklist .warn i { color: #f59e0b; }
.pe-checklist .bad i { color: #ef4444; }

/* Ảnh đại diện */
.pe-thumb {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    aspect-ratio: 16 / 9;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    background: #f9fafb;
    overflow: hidden;
    cursor: pointer;
    transition: border-color .15s, background-color .15s;
}
.pe-thumb.has-image {
    border-style: solid;
    border-color: var(--pe-border);
}
.pe-thumb:hover,
.pe-thumb.dragging {
    border-color: var(--brand);
    background: #fdf3f3;
}
.pe-thumb.is-invalid {
    border-color: #dc2626;
}
.pe-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.pe-thumb__empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    padding: 12px;
    text-align: center;
    color: var(--pe-muted);
    font-size: 13px;
}
.pe-thumb__empty i {
    font-size: 28px;
    color: #9ca3af;
}
.pe-thumb__empty small {
    color: #9ca3af;
}
.pe-thumb__overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, .5);
    color: #fff;
    font-size: 13px;
}

/* Mô tả & Google */
.pe-textarea {
    border-radius: 10px;
    font-size: 14px;
}
.pe-serp {
    margin-top: 12px;
    padding: 12px 14px;
    border-radius: 10px;
    background: #f8fafc;
    font-family: Arial, sans-serif;
}
.pe-serp__label {
    margin-bottom: 6px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
    color: #9ca3af;
}
.pe-serp__url {
    font-size: 12px;
    color: #4d5156;
    word-break: break-all;
}
.pe-serp__title {
    margin: 3px 0 2px;
    font-size: 17px;
    line-height: 1.3;
    color: #1a0dab;
}
.pe-serp__desc {
    font-size: 13px;
    line-height: 1.5;
    color: #4d5156;
}

/* ---------- Xem trước ---------- */
.pe-preview-body {
    background: #eef1f5;
}
.pe-preview {
    margin: 0 auto;
    padding: 32px 40px;
    background: #fff;
    border-radius: 14px;
    transition: max-width .25s;
}
.pe-preview--desktop {
    max-width: 960px;
}
.pe-preview--mobile {
    max-width: 390px;
    padding: 20px 16px;
    border: 10px solid #1f2937;
    border-radius: 34px;
}
.pe-preview__cats {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 10px;
}
.pe-preview__cats span {
    padding: 3px 10px;
    border-radius: 999px;
    background: var(--brand);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}
.pe-preview__hero h1 {
    margin: 0 0 12px;
    font-family: 'Montserrat', 'Open Sans', Arial, sans-serif;
    font-size: 34px;
    font-weight: 700;
    line-height: 1.25;
    color: #1b1f23;
}
.pe-preview--mobile .pe-preview__hero h1 {
    font-size: 24px;
}
.pe-preview__hero p {
    font-size: 17px;
    line-height: 1.6;
    color: #4b5563;
}
.pe-preview__cover {
    width: 100%;
    margin: 8px 0 24px;
    border-radius: 14px;
    aspect-ratio: 16 / 9;
    object-fit: cover;
}
.pe-preview--mobile :deep(.post-content) {
    font-size: 16px;
}
.pe-preview--mobile :deep(.post-content h1) { font-size: 23px !important; }
.pe-preview--mobile :deep(.post-content h2) { font-size: 21px !important; }
.pe-preview--mobile :deep(.post-content h3) { font-size: 18px !important; }

/* ---------- Màn hình nhỏ ---------- */
@media (max-width: 991px) {
    .pe-sheet {
        padding: 32px 32px 40px;
    }
}
@media (max-width: 767px) {
    .pe-topbar {
        padding: 0 10px;
        gap: 6px;
    }
    .pe-topbar__title,
    .pe-status__sep,
    .pe-stats {
        display: none;
    }
    .pe-chip span {
        display: none;
    }
    .pe-canvas {
        padding: 12px 8px 40px;
    }
    .pe-sheet {
        padding: 22px 16px 28px;
        border-radius: 12px;
    }
    .pe-title-input {
        font-size: 26px;
    }
    .pe-content :deep(.tox .tox-editor-header) {
        margin: 0 -6px;
    }
}
</style>
