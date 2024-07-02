<template>
    <div class="container">
        <!-- Button trigger modal -->
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-outline-primary" @click="openAddModal">
                Thêm danh mục
            </button>
        </div>
        <hr>

        <div class="mt-4">
            <h6>Danh mục bài viết</h6>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between" v-for="type in postTypes" :key="type.id">
                    <span>{{ type.type_name }}</span>
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="btn-holder">
                            <div class="toggle-switch">
                                <label :for="'cb-switch-'+type.id">
                                    <input type="checkbox" @change="updateStatus(type)" :checked="type.status" :id="'cb-switch-'+type.id" value="">
                                    <span>
                                    <small></small>
                                  </span>
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-sm" @click="openEditModal(type.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 style="fill: rgb(0,123,255);transform: ;msFilter:;">
                                <path
                                    d="m7 17.013 4.413-.015 9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583v4.43zM18.045 4.458l1.589 1.583-1.597 1.582-1.586-1.585 1.594-1.58zM9 13.417l6.03-5.973 1.586 1.586-6.029 5.971L9 15.006v-1.589z"></path>
                                <path
                                    d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2z"></path>
                            </svg>
                        </button>
                        <button class="btn btn-sm" @click="idDelete = (type.id)" data-toggle="modal"
                                data-target="#exampleModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 style="fill: rgb(190,21,16);transform: ;msFilter:;">
                                <path
                                    d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path>
                                <path d="M9 10h2v8H9zm4 0h2v8h-2z"></path>
                            </svg>
                        </button>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="postTypeModal" tabindex="-1" role="dialog" aria-labelledby="postTypeModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="postTypeModalLabel">{{ mode === 'add' ? 'Thêm' : 'Sửa' }} loại bài
                            viết</h5>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm">
                            <div class="form-group">
                                <label for="type_name">Tên danh mục</label>
                                <input type="text" class="form-control" id="id" v-model="editType.id" hidden>
                                <input type="text" class="form-control" id="type_name" v-model="editType.type_name"
                                       required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ mode === 'add' ? 'Thêm' : 'Lưu' }}</button>
                        </form>
                    </div>
                </div>
            </div>
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
            postTypes: [
                {id: 1, type_name: 'News'},
            ],
            mode: 'add',
            editType: {
                id:'',
                type_name: '',
                status: false,
            },
            idDelete: '',
        }
    },
    components: {
        Modal
    },
    computed: {
        ...mapGetters('category', ['categoryAll','category']),
    },
    watch: {
        categoryAll: function (newValue) {
            this.postTypes = newValue;
        },
        category: function (newValue) {
            this.editType.id = newValue.data.id;
            this.editType.type_name = newValue.data.type_name;
            this.editType.status = newValue.data.status;
        }
    },
    created() {
        this.fetchCategory();
    },
    methods: {
        ...mapActions('category', ['fetchCategory', 'addType', 'deleteType', 'updateType','getOneCategory']),
        openAddModal() {
            this.mode = 'add';
            this.editType.type_name = '';
            this.editType.status = false;
            $('#postTypeModal').modal('show');
        },
        openEditModal(id) {
            this.getOneCategory(id)
            this.mode = 'edit';
            $('#postTypeModal').modal('show');
        },
        async updateStatus(dataOld){
            this.editType.id = dataOld.id;
            this.editType.type_name = dataOld.type_name;
            this.editType.status = !(dataOld.status);
            this.mode = 'edit'
            await this.submitForm()
        },
        async deleteItem() {
            await this.deleteType({id: this.idDelete, toast: this.$toast});
            await this.fetchCategory();
            $('#postTypeModal').modal('hide');
        },
        async submitForm() {
            const data = {
                id: this.editType.id,
                type_name: this.editType.type_name,
                status: this.editType.status,
            };
            if (this.mode == 'add') {
                await this.addType({data, toast: this.$toast});
            } else {
                await this.updateType({data, toast: this.$toast});
            }
            await this.fetchCategory();
            $('#postTypeModal').modal('hide');
            window.location.reload();
        }
    }
}
</script>

<style scoped>
.btn-holder {
    width: 40px;
    height: 30px;
}
.btn-lg.btn-toggle {
    padding: 0;
    margin: 0 5rem;
    position: relative;
    height: 20px;
    width: 30px;
    border-radius: 15px;
    color: #6b7381;
    background: #bdc1c8;
    margin-bottom: 30px;
}
.btn-toggle.btn-lg > .switch {
    position: absolute;
    top: 1px;
    left: 1px;
    width: 18px;
    height: 18px;
    border-radius: 15px;
    background: #fff;
    transition: left .25s;
}
.btn-toggle.active {
    background-color: #B21818;
}
.btn-toggle.btn-lg.active > .switch {
    left: 11px;
    transition: left .25s;
}

.btn-lg.btn-toggle:after {
    content: "";
    right: -5rem;
    opacity: 0.5;
    line-height: 20px;
    width: 5rem;
    text-align: center;
    font-weight: 600;
    font-size: 0.8rem;
    letter-spacing: 1px;
    position: absolute;
    bottom: 0;
    transition: opacity .25s;
}

.btn-lg.btn-toggle.active:after {
    opacity: 1;
}

.toggle-switch {
    width: 40px;
    position: relative;
}
.toggle-switch label {
    padding: 0;
}
input[type="checkbox"] {
    display: none;
}
.toggle-switch label input + span {
    position: relative;
    display: inline-block;
    margin-right: 10px;
    width: 30px;
    height: 20px;
    background: #bdc1c8;
    border: 1px solid #eee;
    border-radius: 15px;
    transition: all 0.3s ease-in-out;
    box-shadow: inset 0 0 5px #828282;
}
.toggle-switch label input + span small {
    position: absolute;
    display: block;
    width: 18px;
    height: 18px;
    border-radius: 15px;
    background: #fff;
    transition: all 0.3s ease-in-out;
    top: 1px;
    left: 1px;
}
.toggle-switch label input:checked + span {
    background-color: #B21818;
}
.toggle-switch label input:checked + span small {
    left: 11px;
    transition: left .25s;
}
.toggle-switch span:after {
    content: "";
    line-height: 20px;
    width: 5rem;
    text-align: center;
    font-weight: 600;
    font-size: 0.8rem;
    letter-spacing: 1px;
    position: absolute;
    bottom: 0;
    transition: opacity .25s;
    left: 30px;
    opacity: 0.5;
    color: #6b7381;
}
.toggle-switch label input:checked + span:after {
    opacity: 1;
}

</style>
