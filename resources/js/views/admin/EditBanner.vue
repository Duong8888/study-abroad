<template>
    <div class="container">
        <div class="d-flex justify-content-end">
            <router-link :to="{name:'TopBanner'}">
                <button class="btn btn-outline-secondary mr-2">Quay lại</button>
            </router-link>
            <button class="btn btn-outline-primary" :class="{'btn-custom-disabled':status}" :disabled="status" @click="saveImages">
                Lưu chỉnh sửa
                <div v-if="status" class="spinner-border text-primary spinner-custom" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </button>
        </div>

        <hr>
        <div class="row">
            <div class="col-sm-2 imgUp" v-for="(image, index) in images" :key="index">
                <div class="imagePreview" :style="{ backgroundImage: 'url(' + image.image_path + ')' }"></div>
                <button type="button" class="btn btn-primary btn-ct w-100" @click="openModal(index)">
                    Tải ảnh lên
                </button>
                <i class="fa fa-times del" @click="removeImage(index)"></i>
            </div>
            <i class="fa fa-plus imgAdd" @click="addImage"></i>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Tải ảnh lên</h5>
                        <button type="button" class="close" @click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label class="w-100 mb-4">
                            Đường dẫn liên kết của banner
                            <input type="text" v-model="modalData.link" class="form-control">
                        </label>
                        <label class="w-100">
                            Tải ảnh lên
                            <input type="file" class="uploadFile img form-control" @change="onModalFileChange">
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                        <button type="button" class="btn btn-primary" @click="saveModalChanges">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import {mapGetters, mapActions} from "vuex";

export default {
    data() {
        return {
            images: [{id: null, image_path: '', file: null, link: ''}],
            deletedImages: [],
            modalData: {
                index: null,
                id: null,
                file: null,
                image_path: '',
                link: ''
            },
            type: 0,
            status: false,
        };
    },
    computed: {
        ...mapGetters('banner', ['bannerAll','statusBtn']),
    },
    watch: {
        bannerAll(newBanner) {
            this.images = newBanner;
        },
        statusBtn: function (newValue) {
            this.status = newValue
        }
    },
    created() {
        const query = this.$route.query;
        if (query.type == 'ads') {
            this.type = 1;
        }
        this.fetchBanner(this.type);
    },
    methods: {
        ...mapActions('banner', ['addBanner', 'updateBanner', 'deleteBanner', 'fetchBanner']),
        addImage() {
            this.images.push({id: null, image_path: '', file: null, link: ''});
        },
        removeImage(index) {
            if (this.images[index].id !== null) {
                this.deletedImages.push(this.images[index].id);
            }
            this.images.splice(index, 1);
        },
        openModal(index) {
            this.modalData.index = index;
            this.modalData.id = this.images[index].id;
            this.modalData.image_path = this.images[index].image_path;
            this.modalData.link = this.images[index].link;
            this.modalData.file = this.images[index].file;
            $('#exampleModalCenter').modal('show');
        },
        onModalFileChange(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onloadend = () => {
                    this.modalData.image_path = reader.result;
                    this.modalData.file = file;
                };
                reader.readAsDataURL(file);
            }
        },
        saveModalChanges() {
            const index = this.modalData.index;
            if (index !== null) {
                this.images.splice(index, 1, {
                    id: this.modalData.id,
                    image_path: this.modalData.image_path,
                    file: this.modalData.file,
                    link: this.modalData.link
                });
            }
            $('#exampleModalCenter').modal('hide');
        },
        async saveImages() {
            const formData = new FormData();
            this.images.forEach((image, index) => {
                if (image.id) {
                    formData.append(`data[${index}][id]`, image.id);
                }
                formData.append(`data[${index}][link]`, image.link || '');
                formData.append(`data[${index}][type]`, this.type);
                if (image.file) {
                    formData.append(`data[${index}][image]`, image.file);
                }
            });

            if (this.deletedImages.length > 0) {
                await this.deleteBanner({ids: JSON.stringify(this.deletedImages), toast: this.$toast});
            }
            await this.addBanner({data: formData, toast: this.$toast});
            this.deletedImages = [];
        },

        closeModal() {
            $('#exampleModalCenter').modal('hide');
        }
    }
};
</script>


<style scoped>
body {
    background-color: #f5f5f5;
}

.imagePreview {
    width: 100%;
    height: 180px;
    background-position: center center;
    background-color: #fff;
    background-size: cover;
    background-repeat: no-repeat;
    display: inline-block;
    box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
}

.btn-ct {
    display: block;
    border-radius: 0px;
    box-shadow: 0px 4px 6px 2px rgba(0, 0, 0, 0.2);
    margin-top: -5px;
}

.imgUp {
    margin-bottom: 15px;
    position: relative;
}

.del {
    position: absolute;
    top: 0px;
    right: 15px;
    width: 30px;
    height: 30px;
    text-align: center;
    line-height: 30px;
    background-color: rgba(255, 255, 255, 0.6);
    cursor: pointer;
}

.imgAdd {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #4bd7ef;
    color: #fff;
    box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.2);
    text-align: center;
    line-height: 30px;
    margin-top: 0px;
    cursor: pointer;
    font-size: 15px;
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

