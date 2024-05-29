<template>
    <div class="container" v-if="!loading">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách bài viết</h6>
                <router-link :to="{name:'CreatePosts'}">
                    <buttons class="btn btn-outline-primary">Thêm mới bài viết</buttons>
                </router-link>
            </div>
            <div class="card-body">
                <div class="table-responsive" ref="dataTableContainer">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Ảnh đại diện</th>
                            <th>Loại bài</th>
                            <th>Thời gian đăng</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Ảnh đại diện</th>
                            <th>Loại bài</th>
                            <th>Thời gian đăng</th>
                            <th>Thao tác</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr v-for="item in data" :key="item.id">
                            <td>{{ item.title }}</td>
                            <td><img class="image-custom" :src="item.thumbnail"></td>
                            <td><span class="badge badge-success mx-1" v-for="i in formatTypePost(item.post_type_id)"> {{ i.name }} </span>
                            </td>
                            <td>{{ formatDateTime(item.created_at) }}</td>
                            <td>
                                <div class="dropdown-center">
                                    <p class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                             height="24">
                                            <path
                                                d="M20 14a2 2 0 1 1-.001-3.999A2 2 0 0 1 20 14ZM6 12a2 2 0 1 1-3.999.001A2 2 0 0 1 6 12Zm8 0a2 2 0 1 1-3.999.001A2 2 0 0 1 14 12Z">
                                            </path>
                                        </svg>
                                    </p>
                                    <ul class="dropdown-menu">
                                        <router-link :to="{ name: 'PostsDetail', params: { slug: item.slug }}">
                                            <li><a style="cursor: pointer;color: black" class="dropdown-item">Xem</a>
                                            </li>
                                        </router-link>
                                        <router-link :to="{ name: 'EditPosts', params: { postsId: item.slug }}">
                                            <li><a style="cursor: pointer;color: black" class="dropdown-item">Sửa bài viết</a>
                                            </li>
                                        </router-link>
                                        <li><a style="cursor: pointer;color: black" @click="(idDelete = item.id)" class="dropdown-item" data-toggle="modal" data-target="#exampleModal">Xóa bài viết</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Modal @delete="deletePosts"></Modal>
    </div>
    <div class="container" v-else>
        <p>Loading...</p>
    </div>
</template>

<script>
import Modal from "@/components/admin/Modal.vue";
export default {
    name: "TablePosts",
    props: {
        data: {
            type: Array,
            default: [],
        }
    },
    components:{
        Modal,
    },
    data() {
        return {
            loading: true,
            dataTable: null,
            idDelete:null,
        }
    },
    watch: {
        data() {
            this.loading = false;
            if (this.dataTable) {
                this.dataTable.destroy();
            }
            this.initDataTable();
        }
    },
    mounted() {
        this.initDataTable();
    },
    methods: {
        initDataTable() {
            this.$nextTick(() => {
                this.dataTable = $(this.$refs.dataTableContainer).find('table').DataTable({
                    "order": [[1, "desc"]],
                    scrollX: true,
                    language: {
                        "sProcessing": "Đang xử lý...",
                        "sLengthMenu": "Xem _MENU_ mục",
                        "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
                        "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                        "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 mục",
                        "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                        "sInfoPostFix": "",
                        "sSearch": "Tìm:",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "Đầu",
                            "sPrevious": "Trước",
                            "sNext": "Tiếp",
                            "sLast": "Cuối"
                        }
                    }
                });
            });
        },
        formatDateTime(dateTimeStr) {
            const date = new Date(dateTimeStr);
            const hours = date.getUTCHours().toString().padStart(2, '0');
            const minutes = date.getUTCMinutes().toString().padStart(2, '0');
            const day = date.getUTCDate().toString().padStart(2, '0');
            const month = (date.getUTCMonth() + 1).toString().padStart(2, '0'); // Tháng bắt đầu từ 0 nên cần +1
            const year = date.getUTCFullYear();
            return `${hours}:${minutes} ${day}/${month}/${year}`;
        },
        updateStatus(id) {
            this.$emit('update', id);
        },
        formatTypePost(data) {
            return JSON.parse(data);
        },
        async deletePosts() {
            this.$emit('delete', {id: this.idDelete, toast: this.$toast})
        }
    }
}
</script>

<style scoped>
.status-0, .status-1 {
    background: #17a2b8;
    color: white;
    padding: 5px;
    font-size: 10px;
    font-weight: bold;
    text-align: center;
    border-radius: 5px;
}

.status-1 {
    background: #28a745 !important;
}

.image-custom {
    width: 180px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
}
.badge-success{
    background: #be1510 !important;
}
</style>
