<template>
    <div>
        <CommentsView :items="items"></CommentsView>
        <div class="container">
            <button @click="openModal(false)" class="btn btn-outline-primary mb-3 float-right">Thêm mới</button>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Ảnh</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Cảm nhận</th>
                    <th scope="col">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="items.length === 0">
                    <td colspan="4" class="text-center">Chưa có cảm nhận nào</td>
                </tr>
                <tr v-for="(item, index) in items" :key="item.id">
                    <td><img :src="item.avatar || defaultAvatar" alt="Avatar" class="table-image"></td>
                    <td>{{ item.name }}</td>
                    <td class="content-cell">{{ item.content }}</td>
                    <td>
                        <div class="d-flex">
                            <button class="btn btn-sm" @click="openModal(true, index)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     style="fill: rgb(0,123,255);">
                                    <path
                                        d="m7 17.013 4.413-.015 9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583v4.43zM18.045 4.458l1.589 1.583-1.597 1.582-1.586-1.585 1.594-1.58zM9 13.417l6.03-5.973 1.586 1.586-6.029 5.971L9 15.006v-1.589z"></path>
                                    <path
                                        d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2z"></path>
                                </svg>
                            </button>
                            <button class="btn btn-sm" @click="idDelete = item.id" data-toggle="modal"
                                    data-target="#deleteTestimonialModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     style="fill: rgb(190,21,16);">
                                    <path
                                        d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path>
                                    <path d="M9 10h2v8H9zm4 0h2v8h-2z"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Modal for Adding/Editing Item -->
        <div class="modal fade" id="editTestimonialModal" tabindex="-1" role="dialog"
             aria-labelledby="editTestimonialModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTestimonialModalLabel">
                            {{ isEdit ? 'Chỉnh sửa cảm nhận' : 'Thêm mới cảm nhận' }}
                        </h5>
                        <button type="button" class="close" @click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="testimonialImage" class="d-flex flex-column align-items-center image-picker">
                                <img :src="currentItem.avatar || defaultAvatar" alt="Preview" class="preview-image">
                                <small class="text-muted mt-2">Bấm vào ảnh để chọn ảnh đại diện (không bắt buộc)</small>
                            </label>
                            <input type="file" accept="image/*" class="form-control" id="testimonialImage" hidden
                                   ref="fileInput" @change="handleFileUpload">
                        </div>
                        <div class="form-group">
                            <label for="testimonialName">Tên học viên</label>
                            <input type="text" class="form-control" v-model="currentItem.name" id="testimonialName"
                                   placeholder="Nhập tên học viên">
                        </div>
                        <div class="form-group">
                            <label for="testimonialContent">Cảm nhận</label>
                            <textarea class="form-control" rows="5" v-model="currentItem.content"
                                      id="testimonialContent" placeholder="Nhập nội dung cảm nhận"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal">Hủy</button>
                        <button type="button" class="btn btn-primary" :class="{'btn-custom-disabled':status}"
                                :disabled="status" @click="saveItem">
                            {{ isEdit ? 'Lưu' : 'Thêm mới' }}
                            <div v-if="status" class="spinner-border text-white spinner-custom" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for Deleting Item -->
        <div class="modal fade" id="deleteTestimonialModal" tabindex="-1" role="dialog"
             aria-labelledby="deleteTestimonialModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteTestimonialModalLabel">Xóa cảm nhận</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xóa cảm nhận này?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-danger" @click="confirmDelete" data-dismiss="modal">Xóa
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CommentsView from '@/components/Comments.vue';
import defaultAvatar from '@/assets/images/testimonial/main-home/avatar/1.jpg';
import {mapActions, mapGetters} from "vuex";

const emptyItem = () => ({id: '', name: '', content: '', avatar: '', avatarFile: null});

export default {
    name: "StudentsFeelings",
    components: {
        CommentsView,
    },
    data() {
        return {
            defaultAvatar,
            currentItem: emptyItem(),
            isEdit: false,
            idDelete: null,
        };
    },
    computed: {
        ...mapGetters('testimonial', ['testimonialAll', 'statusBtn']),
        items() {
            return this.testimonialAll;
        },
        status() {
            return this.statusBtn;
        },
    },
    created() {
        this.fetchTestimonial();
    },
    methods: {
        ...mapActions('testimonial', ['fetchTestimonial', 'addTestimonial', 'updateTestimonial', 'deleteTestimonial']),
        openModal(isEdit, index = null) {
            this.isEdit = isEdit;
            this.currentItem = isEdit && index !== null
                ? {...this.items[index], avatarFile: null}
                : emptyItem();
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = '';
            }
            $('#editTestimonialModal').modal('show');
        },
        async saveItem() {
            if (!this.currentItem.name.trim() || !this.currentItem.content.trim()) {
                this.$toast.open({message: 'Vui lòng nhập tên và nội dung cảm nhận', type: 'error', position: 'top'});
                return;
            }
            const formData = new FormData();
            formData.append('name', this.currentItem.name.trim());
            formData.append('content', this.currentItem.content.trim());
            if (this.currentItem.avatarFile) {
                formData.append('avatar', this.currentItem.avatarFile);
            }

            const ok = this.isEdit
                ? await this.updateTestimonial({id: this.currentItem.id, data: formData, toast: this.$toast})
                : await this.addTestimonial({data: formData, toast: this.$toast});
            if (ok) {
                await this.fetchTestimonial();
                this.closeModal();
            }
        },
        closeModal() {
            $('#editTestimonialModal').modal('hide');
        },
        async confirmDelete() {
            await this.deleteTestimonial({id: this.idDelete, toast: this.$toast});
            await this.fetchTestimonial();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.currentItem.avatarFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.currentItem.avatar = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    }
}
</script>


<style scoped>
.table-image {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}
.content-cell {
    max-width: 500px;
    white-space: pre-line;
}
.image-picker {
    cursor: pointer;
}
.preview-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
}
.spinner-custom{
    width: 20px;
    height: 20px;
}
.btn-custom-disabled{
    opacity: 0.5;
    user-select: none;
}
.btn-custom-disabled:hover {
    opacity: 0.5 !important;
}
</style>
