<template>
    <div id="main-content" class="file_manager">
        <div class="container">
            <div class="row clearfix">
                <div v-for="(file,index) in paginatedItems" :key="index" class="col-lg-3 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="file">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#exampleModal" @click="fileDelete = (file.url).split('/').pop()">
                                <div class="hover">
                                    <button type="button" class="btn btn-icon btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                <div class="image">
                                    <img :src="file.url" alt="img"
                                         class="img-fluid">
                                </div>
                                <div class="file-name">
                                    <p class="m-b-5 text-muted">{{(file.url).split('/').pop()}}</p>
                                    <small>Size: {{file.size}}KB </small>
                                    <p class="m-0"><span class="date text-muted">{{file.last_modified}}</span></p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Pagination
        v-if="files.length > 0"
        :totalItems="files.length"
        :itemsPerPage="itemsPerPage"
        v-model:currentPage="currentPage"
    />
    <Modal @delete="deleteFile"></Modal>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Pagination from '../../components/Pagination.vue';
import Modal from "@/components/admin/Modal.vue";

export default {
    name: "FileManager",
    data() {
        return {
            files:[],
            itemsPerPage:12,
            currentPage: 1,
            fileDelete: '',
        }
    },
    components:{
        Pagination,
        Modal
    },
    created() {
        this.fetchFiles();
    },
    computed: {
        ...mapGetters('files',['filesAll']),
        paginatedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.files.slice(start, end);
        }
    },
    watch: {
        filesAll: function(files){
            this.files = files
        }
    },
    methods: {
        ...mapActions('files', ['fetchFiles','deleteFiles']),
        async deleteFile(){
            await this.deleteFiles({fileName: this.fileDelete, toast: this.$toast});
            await this.fetchFiles();
        }
    },
}
</script>

<style scoped>
.file_manager .file a:hover .hover,
.file_manager .file .file-name small {
    display: block
}

.file_manager .file {
    padding: 0 !important
}

.file_manager .file .icon {
    text-align: center
}


.file_manager .file {
    position: relative;
    border-radius: .55rem;
    overflow: hidden
}

.file_manager .file .image,
.file_manager .file .icon {
    max-height: 180px;
    overflow: hidden;
    background-size: cover;
    background-position: top
}

.file_manager .file .hover {
    position: absolute;
    right: 10px;
    top: 10px;
    display: none;
    transition: all 0.2s ease-in-out
}

.file_manager .file a:hover .hover {
    transition: all 0.2s ease-in-out
}

.file_manager .file .icon {
    padding: 15px 10px;
    display: table;
    width: 100%
}

.file_manager .file .icon i {
    display: table-cell;
    font-size: 30px;
    vertical-align: middle;
    color: #777;
    line-height: 100px
}

.file_manager .file .file-name {
    padding: 10px;
    border-top: 1px solid #f7f7f7
}

.file_manager .file .file-name small .date {
    float: right
}

.folder {
    padding: 20px;
    display: block;
    color: #777
}

@media only screen and (max-width: 992px) {
    .file_manager .nav-tabs {
        padding-left: 0;
        padding-right: 0
    }

    .file_manager .nav-tabs .nav-item {
        display: inline-block
    }
}

.card {
    background: #fff;
    transition: .5s;
    border: 0;
    margin-bottom: 30px;
    border-radius: .55rem;
    position: relative;
    width: 100%;
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
}

a:hover {
    text-decoration: none;
}
.img-fluid{
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.file-name  > p{
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
}
</style>
