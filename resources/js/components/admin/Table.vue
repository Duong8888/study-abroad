<template>
    <div class="container" v-if="!loading">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Yêu cầu tư vấn</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" ref="dataTableContainer">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Nội dung tư vấn</th>
                            <th>Trạng thái</th>
                            <th>Thời gian gửi</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Nội dung tư vấn</th>
                            <th>Trạng thái</th>
                            <th>Thời gian gửi</th>
                            <th>Thao tác</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr v-for="item in data" :key="item.id">
                            <td>{{ item.name }}</td>
                            <td>{{ item.phone_number }}</td>
                            <td>{{ item.email }}</td>
                            <td>{{ item.content }}</td>
                            <td><p :class="{'status-0':(item.status == 0),'status-1':(item.status == 1)}">{{ (item.status == 0) ? "Đơn đang ký mới ": "Đã tư vấn" }}</p></td>
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
                                        <li><a style="cursor: pointer" class="dropdown-item" @click="updateStatus(item.id)">Xác nhận đã tư vấn</a></li>
<!--                                        <li><a style="cursor: pointer" class="dropdown-item" >Action two</a></li>-->
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
                this.dataTable = $(this.$refs.dataTableContainer).find('table').DataTable({
                    "order": [[5, "desc"]],
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
            let hours = date.getUTCHours();
            let minutes = date.getUTCMinutes();
            let day = date.getUTCDate();
            let month = date.getUTCMonth() + 1;
            let year = date.getUTCFullYear();
            hours += 7;
            if (hours >= 24) {
                hours -= 24;
                day += 1;
                const daysInMonth = new Date(year, month, 0).getDate();
                if (day > daysInMonth) {
                    day = 1;
                    month += 1;
                    if (month > 12) {
                        month = 1;
                        year += 1;
                    }
                }
            }
            hours = hours.toString().padStart(2, '0');
            minutes = minutes.toString().padStart(2, '0');
            day = day.toString().padStart(2, '0');
            month = month.toString().padStart(2, '0');
            return `${day}/${month}/${year}`;
        },
        updateStatus(id){
            this.$emit('update',id);
        }
    }
}
</script>

<style scoped>
.status-0, .status-1{
    background: #be1510 !important;
    color: white;
    padding: 5px;
    font-size: 10px;
    font-weight: bold;
    text-align: center;
    border-radius: 5px;
}
.status-1{
    background: #28a745 !important;
}
.btn-outline-primary{
    color: #be1510 !important;
    background: #be1510 !important;
}
</style>
