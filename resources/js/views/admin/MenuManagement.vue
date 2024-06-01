<template>
    <div class="container mt-5">
        <!-- Button to trigger modal -->
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-outline-primary" @click="openAddModal">
                Thêm mới menu
            </button>
        </div>
        <hr>

        <!-- Modal -->
        <div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="menuModalLabel">{{ isEdit ? 'Chỉnh sửa menu' : 'Thêm menu' }}</h5>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="validateAndSubmitMenuItem">
                            <div class="form-group">
                                <label for="menuName">Tên menu</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="menuName"
                                    v-model="currentMenuItem.title"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="menuUrl">URL menu</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="menuUrl"
                                    v-model="currentMenuItem.url"
                                />
                            </div>
                            <div class="form-group">
                                <label for="parentMenu">Menu cha</label>
                                <select
                                    class="form-control"
                                    id="parentMenu"
                                    v-model="currentMenuItem.parent_id"
                                    @change="clearUrl"
                                >
                                    <option :value="null">None</option>
                                    <option
                                        v-for="item in menuItems.filter(item => item.parent_id === null)"
                                        :key="item.id"
                                        :value="item.id"
                                    >
                                        {{ item.title }}
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ isEdit ? 'Lưu' : 'Thêm mới' }}</button>
                        </form>
                        <div v-if="errorMessage" class="alert alert-danger mt-2">
                            {{ errorMessage }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h6>Cấu trúc Menu</h6>
            <ul class="list-group">
                <li v-for="item in menuItems.filter(item => item.parent_id === null)" :key="item.id"
                    class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div>
                            <a :href="item.url">{{ item.title }}</a>
                        </div>
                        <div>
                            <button class="btn btn-sm" @click="openEditModal(item)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(0,123,255);transform: ;msFilter:;"><path d="m7 17.013 4.413-.015 9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583v4.43zM18.045 4.458l1.589 1.583-1.597 1.582-1.586-1.585 1.594-1.58zM9 13.417l6.03-5.973 1.586 1.586-6.029 5.971L9 15.006v-1.589z"></path><path d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2z"></path></svg>
                            </button>
                            <button class="btn btn-sm" @click="idDelete = (item.id)" data-toggle="modal" data-target="#exampleModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(190,21,16);transform: ;msFilter:;"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg>
                            </button>
                        </div>
                    </div>
                    <ul class="list-group mt-2 w-100">
                        <li v-for="child in getChildItems(item.id)" :key="child.id" class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <a :href="child.url">{{ child.title }}</a>
                                </div>
                                <div>
                                    <button class="btn btn-sm" @click="openEditModal(child)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(0,123,255);transform: ;msFilter:;"><path d="m7 17.013 4.413-.015 9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583v4.43zM18.045 4.458l1.589 1.583-1.597 1.582-1.586-1.585 1.594-1.58zM9 13.417l6.03-5.973 1.586 1.586-6.029 5.971L9 15.006v-1.589z"></path><path d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2z"></path></svg>
                                    </button>
                                    <button class="btn btn-sm" @click="idDelete = (child.id)" data-toggle="modal" data-target="#exampleModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(190,21,16);transform: ;msFilter:;"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <Modal @delete="deleteItem"></Modal>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Modal from "@/components/admin/Modal.vue";
export default {
    data() {
        return {
            newMenuItem: {
                title: '',
                url: '',
                parent_id: null,
            },
            currentMenuItem: {
                id: null,
                title: '',
                url: '',
                parent_id: null,
            },
            menuItems: [
                {id: 1, title: 'Home', url: '/', parent_id: null},
                {id: 2, title: 'About', url: '/about', parent_id: null},
                {id: 3, title: 'Team', url: '/about/team', parent_id: 2},
            ],
            nextId: 4,
            errorMessage: '',
            isEdit: false,
            idDelete:'',
        };
    },
    computed: {
        ...mapGetters('menu', ['menuAll']),
    },
    watch: {
        menuAll: function (newValue) {
            this.menuItems = newValue;
        },
    },
    created() {
        this.fetchMenu();
    },
    methods: {
        ...mapActions('menu', ['fetchMenu', 'addMenu','updateMenu','deleteMenu']),
        openAddModal() {
            this.isEdit = false;
            this.currentMenuItem = {id: null, title: '', url: '', parent_id: null};
            this.errorMessage = '';
            $('#menuModal').modal('show');
        },
        openEditModal(item) {
            this.isEdit = true;
            this.currentMenuItem = {...item};
            this.errorMessage = '';
            $('#menuModal').modal('show');
        },
        validateAndSubmitMenuItem() {
            this.errorMessage = '';

            if (!this.currentMenuItem.title) {
                this.errorMessage = 'Tên là bắt buộc.';
                return;
            }

            if (this.currentMenuItem.parent_id && !this.currentMenuItem.url) {
                this.errorMessage = 'URL là bắt buộc khi một menu cha được chọn.';
                return;
            }

            if (this.isEdit) {
                this.updateMenuItem();
            } else {
                this.addMenuItem();
            }
        },
        async addMenuItem() {
            const data = {
                title: this.currentMenuItem.title,
                url: this.currentMenuItem.url,
                parent_id: this.currentMenuItem.parent_id,
            };
            await this.addMenu({data: data, toast: this.$toast});
            await this.fetchMenu();
            this.currentMenuItem = {id: null, title: '', url: '', parent_id: null};
            $('#menuModal').modal('hide');
        },
        async updateMenuItem() {
            const data = {
                id: this.currentMenuItem.id,
                title: this.currentMenuItem.title,
                url: this.currentMenuItem.url,
                parent_id: this.currentMenuItem.parent_id,
            };
            await this.updateMenu({data: data, toast: this.$toast});
            await this.fetchMenu();
            this.currentMenuItem = {id: null, title: '', url: '', parent_id: null};
            $('#menuModal').modal('hide');
        },
        async deleteItem(){
            await this.deleteMenu({id: this.idDelete, toast: this.$toast});
            await this.fetchMenu();
        },
        getChildItems(parentId) {
            return this.menuItems.filter(item => item.parent_id == parentId);
        },
        clearUrl() {
            if (this.currentMenuItem.parent_id === null) {
                this.currentMenuItem.url = '';
            }
        },
    },
    components:{
        Modal,
    }
};
</script>

<style scoped>
.list-group-item {
    border: none;
    padding: 10px 20px;
    font-weight: bold;
    flex-direction: column;
    background-color: #ffffff;
    align-items: start;
    margin-bottom: 5px;
    display: flex;
    justify-content: space-between;
    border-left: 4px solid #007bff;
    border-radius: 4px;
}

.list-group-item a {
    text-decoration: none;
    color: #007bff;
}

.list-group-item a:hover {
    text-decoration: underline;
}

.list-group-item > .list-group {
    margin-left: 20px;
    padding-left: 10px;
}

.modal-header, .modal-footer {
    background-color: #f1f1f1;
}

.modal-title {
    color: #007bff;
}

.btn-outline-secondary {
    border-color: #007bff;
    color: #007bff;
}

.btn-outline-secondary:hover {
    background-color: #007bff;
    color: white;
}
</style>
