<template>
    <div class="container" v-if="!loading">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">User request</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" ref="dataTableContainer">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Time request</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Time request</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr v-for="item in data" :key="item.id">
                            <td>{{ item.name }}</td>
                            <td>{{ item.phone }}</td>
                            <td>{{ item.email }}</td>
                            <td>{{ item.status }}</td>
                            <td>{{ item.time }}</td>
                            <td>
                                <div class="dropdown-center">
                                    <p class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                            <path
                                                d="M20 14a2 2 0 1 1-.001-3.999A2 2 0 0 1 20 14ZM6 12a2 2 0 1 1-3.999.001A2 2 0 0 1 6 12Zm8 0a2 2 0 1 1-3.999.001A2 2 0 0 1 14 12Z">
                                            </path>
                                        </svg>
                                    </p>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Action two</a></li>
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
    name: "Table",
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
                this.dataTable = $(this.$refs.dataTableContainer).find('table').DataTable();
            });
        }
    }
}
</script>

<style scoped>
</style>
