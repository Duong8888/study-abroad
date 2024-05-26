<template>
    <div class="container" v-if="!loading">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Posts List</h6>
                <router-link :to="{name:'CreatePosts'}">
                    <buttons class="btn btn-outline-primary">Add new posts</buttons>
                </router-link>
            </div>
            <div class="card-body">
                <div class="table-responsive" ref="dataTableContainer">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Thumbnail</th>
                            <th>Content</th>
                            <th>Author</th>
                            <th>Posts Type</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Title</th>
                            <th>Thumbnail</th>
                            <th>Content</th>
                            <th>Author</th>
                            <th>Posts Type</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr v-for="item in data" :key="item.id">
                            <td>{{ item.title }}</td>
                            <td>{{ item.thumbnail }}</td>
                            <td v-html="item.content"></td>
                            <td>{{ item.author_id }}</td>
                            <td>{{ item.post_type_id }}</td>
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
                                        <li><a style="cursor: pointer" class="dropdown-item">View</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container" v-else>
        <p>Loading...</p>
    </div>
</template>

<script>
export default {
    name: "TablePosts",
    props: {
        data: {
            type: Array,
            default: [],
        }
    },
    data() {
        return {
            loading: true,
            dataTable: null
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
</style>
