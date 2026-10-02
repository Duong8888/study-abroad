<template>
    <div class="container">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-outline-primary" @click="openAddModal">
                Thêm video
            </button>
        </div>
        <hr>

        <div class="mt-4">
            <h6>Video TikTok hiển thị trên trang chủ</h6>
            <p class="text-muted small">Trang chủ hiển thị video theo thứ tự mới thêm trước, 3 video mỗi hàng.</p>
            <ul class="list-group">
                <li v-if="videos.length === 0" class="list-group-item text-muted">Chưa có video nào.</li>
                <li class="list-group-item d-flex justify-content-between align-items-center" v-for="video in videos" :key="video.id">
                    <div class="text-truncate mr-3">
                        <div class="font-weight-bold">{{ video.video_title || '(Không có tiêu đề)' }}</div>
                        <small>
                            {{ video.author_username }} ·
                            <a :href="video.video_url" target="_blank">{{ video.video_url }}</a>
                        </small>
                    </div>
                    <div class="d-flex align-items-center flex-shrink-0">
                        <button class="btn btn-sm" @click="openEditModal(video)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 style="fill: rgb(0,123,255);">
                                <path
                                    d="m7 17.013 4.413-.015 9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583v4.43zM18.045 4.458l1.589 1.583-1.597 1.582-1.586-1.585 1.594-1.58zM9 13.417l6.03-5.973 1.586 1.586-6.029 5.971L9 15.006v-1.589z"></path>
                                <path
                                    d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2z"></path>
                            </svg>
                        </button>
                        <button class="btn btn-sm" @click="idDelete = video.id" data-toggle="modal"
                                data-target="#exampleModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 style="fill: rgb(190,21,16);">
                                <path
                                    d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path>
                                <path d="M9 10h2v8H9zm4 0h2v8h-2z"></path>
                            </svg>
                        </button>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Modal thêm / sửa -->
        <div class="modal fade" id="tiktokModal" tabindex="-1" role="dialog" aria-labelledby="tiktokModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tiktokModalLabel">{{ mode === 'add' ? 'Thêm' : 'Sửa' }} video TikTok</h5>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm">
                            <div class="form-group">
                                <label for="video_url">Link video</label>
                                <input type="url" class="form-control" id="video_url" v-model="form.video_url"
                                       placeholder="https://www.tiktok.com/@du.hc.smartedu/video/7384067532929518865" required>
                                <small class="form-text text-muted">
                                    Mở video trên trình duyệt máy tính rồi copy link trên thanh địa chỉ.
                                    Link rút gọn dạng vt.tiktok.com không dùng được.
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="video_title">Tiêu đề (không bắt buộc, chỉ để dễ quản lý)</label>
                                <input type="text" class="form-control" id="video_title" v-model="form.video_title">
                            </div>
                            <button type="submit" class="btn btn-primary" :disabled="loading">
                                {{ mode === 'add' ? 'Thêm' : 'Lưu' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Modal @delete="deleteItem"></Modal>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Modal from "@/components/admin/Modal.vue";

export default {
    name: "TikTok",
    data() {
        return {
            videos: [],
            mode: 'add',
            form: {
                id: '',
                video_url: '',
                video_title: '',
            },
            idDelete: '',
            loading: false,
        }
    },
    components: {
        Modal
    },
    computed: {
        ...mapGetters('tiktok', ['tiktokAll']),
    },
    watch: {
        tiktokAll: function (newValue) {
            this.videos = newValue;
        },
    },
    created() {
        this.fetchTiktok();
    },
    methods: {
        ...mapActions('tiktok', ['fetchTiktok', 'addTiktok', 'updateTiktok', 'deleteTiktok']),
        openAddModal() {
            this.mode = 'add';
            this.form = {id: '', video_url: '', video_title: ''};
            $('#tiktokModal').modal('show');
        },
        openEditModal(video) {
            this.mode = 'edit';
            this.form = {id: video.id, video_url: video.video_url, video_title: video.video_title};
            $('#tiktokModal').modal('show');
        },
        async deleteItem() {
            await this.deleteTiktok({id: this.idDelete, toast: this.$toast});
            await this.fetchTiktok();
        },
        async submitForm() {
            this.loading = true;
            const data = {...this.form};
            const success = (this.mode === 'add')
                ? await this.addTiktok({data, toast: this.$toast})
                : await this.updateTiktok({data, toast: this.$toast});
            this.loading = false;
            if (success) {
                $('#tiktokModal').modal('hide');
                await this.fetchTiktok();
            }
        }
    }
}
</script>
