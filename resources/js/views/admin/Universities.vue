<template>
    <div>
        <UniversitiesCmp :items="items" :showTitle="false"></UniversitiesCmp>
        <div class="container">
            <button @click="openModal(false)" class="btn btn-outline-primary mb-3 float-right">Thêm mới</button>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Tên</th>
                    <th scope="col">Ảnh</th>
                    <th scope="col">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in items" :key="index">
                    <td>{{ item.university_name }}</td>
                    <td><img :src="item.logo" alt="Image" class="table-image"></td>
                    <td>
                        <div>
                            <button class="btn btn-sm" @click="openModal(true, index)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     style="fill: rgb(0,123,255);transform: ;msFilter:;">
                                    <path
                                        d="m7 17.013 4.413-.015 9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583v4.43zM18.045 4.458l1.589 1.583-1.597 1.582-1.586-1.585 1.594-1.58zM9 13.417l6.03-5.973 1.586 1.586-6.029 5.971L9 15.006v-1.589z"></path>
                                    <path
                                        d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2z"></path>
                                </svg>
                            </button>
                            <button class="btn btn-sm" @click="idDelete = item.id" data-toggle="modal"
                                    data-target="#deleteModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     style="fill: rgb(190,21,16);transform: ;msFilter:;">
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
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">{{ isEdit ? 'Chỉnh sửa mục' : 'Thêm mới mục' }}</h5>
                        <button type="button" class="close" @click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="itemName">Tên</label>
                            <input type="text" class="form-control" v-model="currentItem.university_name" id="itemName"
                                   placeholder="Nhập tên">
                            <input type="text" class="form-control" v-model="currentItem.id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="itemImage" class="d-flex justify-content-center">
                                <svg v-if="!currentItem.logo" xmlns="http://www.w3.org/2000/svg" width="100"
                                     height="100" viewBox="0 0 24 24"
                                     style="fill: #cccc;transform: ;msFilter:;">
                                    <path
                                        d="M4 5h13v7h2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-2H4V5z"></path>
                                    <path d="m8 11-3 4h11l-4-6-3 4z"></path>
                                    <path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z"></path>
                                </svg>
                                <img v-if="currentItem.logo" :src="currentItem.logo" alt="Preview"
                                     class="preview-image">
                            </label>
                            <input type="file" class="form-control" id="itemImage" hidden @change="handleFileUpload">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal">Hủy</button>
                        <button type="button" class="btn btn-primary" :class="{'btn-custom-disabled':status}" :disabled="status" @click="saveItem">{{
                                isEdit ? 'Lưu' : 'Thêm mới'
                            }}
                            <div v-if="status" class="spinner-border text-white spinner-custom" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for Deleting Item -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Xóa mục</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xóa mục này?
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
import UniversitiesCmp from '@/components/Universities.vue';
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Universities",
    components: {
        UniversitiesCmp,
    },
    data() {
        return {
            items: [
                {university_name: 'Mincin Funo', logo: '/assets/images/team/6.jpg'},
                {university_name: 'John Doe', logo: '/assets/images/team/7.jpg'},
            ],
            currentItem: {university_name: '', logo: '', id: '', logoFile: null},
            isEdit: false,
            idDelete: null,
            status: false,
        };
    },
    computed: {
        ...mapGetters('universities', ['universityAll','statusBtn'])
    },
    created() {
        this.fetchItem();
    },
    watch: {
        universityAll: function (newValue) {
            this.items = newValue
        },
        statusBtn: function (newValue) {
            this.status = newValue
        }
    },
    methods: {
        ...mapActions('universities', ['fetchItem', 'addItem', 'updateItem', 'deleteItem']),
        openModal(isEdit, index = null) {
            this.isEdit = isEdit;
            if (isEdit && index !== null) {
                this.currentItem = {...this.items[index], index};
            } else {
                this.currentItem = {university_name: '', image: '', logoFile: null, id: ''};
            }
            $('#editModal').modal('show');
        },
        async saveItem() {
            try {
                const formData = new FormData();
                formData.append('name', this.currentItem.university_name);
                formData.append('logo', this.currentItem.logoFile);

                if (this.isEdit) {
                    formData.append('id', this.currentItem.id);
                    await this.updateItem({data: formData, toast: this.$toast});
                } else {
                    await this.addItem({data: formData, toast: this.$toast});
                }
                await this.fetchItem();
                this.closeModal();
            } catch (error) {
                console.error('Error saving item:', error);
            }
        },
        closeModal() {
            $('#editModal').modal('hide');
        },
        async confirmDelete() {
            console.log(this.idDelete);
            await this.deleteItem({id: this.idDelete, toast: this.$toast});
            await this.fetchItem();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.currentItem.logoFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.currentItem.logo = e.target.result;
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
