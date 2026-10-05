<template>
    <div class="container mt-5">
        <!-- Button to trigger modal -->
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Menu hiển thị tối đa 3 cấp, sắp xếp theo ô "Thứ tự" (số nhỏ đứng trước).</small>
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
                        <button type="button" class="close" @click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
                                    placeholder="/blogs/ten-bai-viet"
                                />
                                <small class="form-text text-muted">Menu có menu con thì không cần URL (bấm vào sẽ mở menu con).</small>
                            </div>
                            <div class="form-group">
                                <label for="parentMenu">Menu cha</label>
                                <select
                                    class="form-control"
                                    id="parentMenu"
                                    v-model="currentMenuItem.parent_id"
                                >
                                    <option :value="null">Không có (menu cấp 1)</option>
                                    <option
                                        v-for="item in parentOptions"
                                        :key="item.id"
                                        :value="item.id"
                                    >
                                        {{ item.depth === 2 ? '   — ' : '' }}{{ item.title }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label for="menuOrder">Thứ tự</label>
                                    <input type="number" class="form-control" id="menuOrder" min="0"
                                           v-model.number="currentMenuItem.order">
                                </div>
                                <div class="form-group col-6 d-flex align-items-end">
                                    <div class="custom-control custom-switch mb-2">
                                        <input type="checkbox" class="custom-control-input" id="menuActive"
                                               v-model="currentMenuItem.is_active">
                                        <label class="custom-control-label" for="menuActive">Hiển thị</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ isEdit ? 'Lưu' : 'Thêm mới' }}</button>
                            <button type="button" class="btn btn-secondary mx-2" @click="closeModal">Hủy</button>
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
                <li v-for="item in flatTree" :key="item.id" class="list-group-item"
                    :class="[`depth-${item.depth}`, {inactive: !isActive(item)}]">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div>
                            <span class="menu-order" title="Thứ tự">{{ item.order ?? '–' }}</span>
                            <a :href="item.url || '#'">{{ item.title }}</a>
                            <small v-if="item.url" class="text-muted ml-2">{{ item.url }}</small>
                            <span v-if="!isActive(item)" class="badge badge-secondary ml-2">Đang ẩn</span>
                        </div>
                        <div class="text-nowrap">
                            <button class="btn btn-sm" title="Sửa" @click="openEditModal(item)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(0,123,255);"><path d="m7 17.013 4.413-.015 9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583v4.43zM18.045 4.458l1.589 1.583-1.597 1.582-1.586-1.585 1.594-1.58zM9 13.417l6.03-5.973 1.586 1.586-6.029 5.971L9 15.006v-1.589z"></path><path d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2z"></path></svg>
                            </button>
                            <button class="btn btn-sm" title="Xóa" @click="idDelete = (item.id)" data-toggle="modal" data-target="#exampleModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(190,21,16);"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg>
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <Modal @delete="deleteItem"></Modal>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Modal from "@/components/admin/Modal.vue";

const emptyItem = () => ({id: null, title: '', url: '', parent_id: null, order: null, is_active: true});

export default {
    data() {
        return {
            currentMenuItem: emptyItem(),
            menuItems: [],
            errorMessage: '',
            isEdit: false,
            idDelete: '',
        };
    },
    computed: {
        ...mapGetters('menu', ['menuAll']),
        // Cây menu dàn phẳng kèm độ sâu (1-3), sắp theo thứ tự
        flatTree() {
            const sorted = [...this.menuItems].sort((a, b) => (a.order ?? 9999) - (b.order ?? 9999) || a.id - b.id);
            const result = [];
            const walk = (parentId, depth) => {
                sorted.filter(item => (item.parent_id ?? null) == parentId).forEach(item => {
                    result.push({...item, depth});
                    if (depth < 3) walk(item.id, depth + 1);
                });
            };
            walk(null, 1);
            return result;
        },
        // Menu cha chỉ được là cấp 1 hoặc 2 (để tối đa 3 cấp), không chọn chính nó
        parentOptions() {
            const editingId = this.currentMenuItem.id;
            const hasChildren = editingId && this.menuItems.some(item => item.parent_id == editingId);
            return this.flatTree.filter(item =>
                (!editingId || (item.id !== editingId && item.parent_id != editingId))
                && (item.depth === 1 || (item.depth === 2 && !hasChildren)));
        },
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
        ...mapActions('menu', ['fetchMenu', 'addMenu', 'updateMenu', 'deleteMenu']),
        isActive(item) {
            return item.is_active === null || item.is_active === undefined || !!Number(item.is_active);
        },
        openAddModal() {
            this.isEdit = false;
            this.currentMenuItem = emptyItem();
            this.errorMessage = '';
            $('#menuModal').modal('show');
        },
        openEditModal(item) {
            this.isEdit = true;
            this.currentMenuItem = {...emptyItem(), ...item, is_active: this.isActive(item)};
            this.errorMessage = '';
            $('#menuModal').modal('show');
        },
        validateAndSubmitMenuItem() {
            this.errorMessage = '';
            if (!this.currentMenuItem.title) {
                this.errorMessage = 'Tên là bắt buộc.';
                return;
            }
            if (this.isEdit) {
                this.updateMenuItem();
            } else {
                this.addMenuItem();
            }
        },
        payload() {
            const item = this.currentMenuItem;
            return {
                title: item.title,
                url: item.url || null,
                parent_id: item.parent_id,
                order: item.order === '' || item.order === null ? null : Number(item.order),
                is_active: item.is_active ? 1 : 0,
            };
        },
        async addMenuItem() {
            await this.addMenu({data: this.payload(), toast: this.$toast});
            await this.fetchMenu();
            this.currentMenuItem = emptyItem();
            $('#menuModal').modal('hide');
        },
        async updateMenuItem() {
            await this.updateMenu({data: {id: this.currentMenuItem.id, ...this.payload()}, toast: this.$toast});
            await this.fetchMenu();
            this.currentMenuItem = emptyItem();
            $('#menuModal').modal('hide');
        },
        async deleteItem() {
            await this.deleteMenu({id: this.idDelete, toast: this.$toast});
            await this.fetchMenu();
        },
        closeModal() {
            $('#menuModal').modal('hide');
        },
    },
    components: {
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

.list-group-item.depth-2 {
    margin-left: 32px;
    border-left-color: #60a5fa;
    font-weight: 600;
}
.list-group-item.depth-3 {
    margin-left: 64px;
    border-left-color: #bfdbfe;
    font-weight: 500;
}
.list-group-item.inactive {
    opacity: .6;
}
.menu-order {
    display: inline-block;
    min-width: 26px;
    margin-right: 8px;
    padding: 0 6px;
    border-radius: 6px;
    background: #f1f5f9;
    color: #64748b;
    font-size: 12px;
    text-align: center;
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
