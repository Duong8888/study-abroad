<template>
<!--    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">-->
<!--        Launch demo modal-->
<!--    </button>-->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bài viết sẽ bị xóa khỏi hệ thống. Bạn có chắc chắn xóa chứ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" @click="confirmDelete" data-dismiss="modal">Đồng ý và tiếp tục</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Modal",
    methods:{
        confirmDelete(){
            this.$emit('delete');
        }
    }
}
</script>

<style scoped>

</style>
