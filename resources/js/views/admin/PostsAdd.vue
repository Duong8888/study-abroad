<script setup>
import Editor from '@tinymce/tinymce-vue';
</script>

<template>
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ formType ? "Create posts" : "Edit posts" }}</h6>
            </div>
            <div class="row p-4">
                <div class="col-12">
                    <div class="w-100">
                        <label for="inputTitle" class="form-label">Title</label>
                        <input type="text" class="form-control mb-20" id="inputTitle" placeholder="Title"
                               v-model="title" aria-label="Title">
                    </div>
                    <div class="w-100">
                        <label for="inputSlug" class="form-label">Slug</label>
                        <input type="text" class="form-control mb-20" id="inputSlug" placeholder="Slug"
                               v-model="slug"
                               aria-label="Slug">
                    </div>
                    <div class="w-100 mb-20">
                        <label for="inputSlug" class="form-label">Category</label>
                        <Multiselect class="form-label"
                                     v-model="value"
                                     mode="tags"
                                     :close-on-select="false"
                                     :searchable="true"
                                     :create-option="true"
                                     :options="category"
                                     :taggable="true"
                                     label="label"
                        />
                    </div>

                    <div class="w-100 mb-20">
                        <label for="inputSlug" class="form-label ">Description</label>
                        <textarea name="description" v-model="description" placeholder="Description"
                                  class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <main id="sample" class="p-4">
                <label for="inputSlug" class="form-label mb-20">Content</label>
                <Editor
                    v-model="editorContent"
                    :api-key="apiKey"
                    :init="editorConfig"
                />
            </main>
            <div class="col-12">
                <input hidden type="file" class="form-control" id="imageInput" ref="imageInput"
                       @change="previewImage"
                       accept="image/*">
                <label for="imageInput" class="form-label box-img">
                    <p v-if="!imageUrl" class="d-flex flex-column align-items-center justify-content-center">
                        <span>Thumbnail</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24"
                             style="fill: #cccc;transform: ;msFilter:;">
                            <path
                                d="M4 5h13v7h2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-2H4V5z"></path>
                            <path d="m8 11-3 4h11l-4-6-3 4z"></path>
                            <path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z"></path>
                        </svg>
                    </p>
                    <img v-if="imageUrl" :src="imageUrl" class="" alt="Preview" style="max-width: 100%">
                </label>
            </div>
            <div class="col-12 py-4 d-flex justify-content-end">
                <router-link :to="{name:'Posts'}">
                    <button class="btn btn-light mx-1">Cancel</button>
                </router-link>
                <button class="btn btn-primary" @click="actionBtn(getData)">{{ formType ? "Save" : "Update" }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import TextEdit from '../../components/admin/TextEdit.vue';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import {mapGetters, mapActions} from "vuex";

export default {
    name: "PostsAdd",
    data() {
        return {
            title: '',
            slug: '',
            imageUrl: null,
            value: [],
            description: null,
            thumbnail: null,
            editorContent: null,
            formType: true,
            id: null,

            apiKey: 'g00klohzu757d7qwuw6rupo7nuezdho9d9j9hcr083mmkpy1',
            editorConfig: {
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | addcomment showcomments | spellcheckdialog a11ycheck | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                // plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
                // toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image',

                file_picker_callback: (cb, value, meta) => {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.addEventListener('change', (e) => {
                        const file = e.target.files[0];
                        const formData = new FormData();
                        formData.append('upload', file);

                        axios.post('/api/upload-image', formData)
                            .then(response => {
                                const imageUrl = response.data.url;
                                cb(imageUrl, {title: file.name});
                                console.log('File uploaded successfully:', imageUrl);
                            })
                            .catch(error => {
                                console.error('Error uploading file:', error);
                            });
                    });

                    input.click();
                },
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
            }
        };
    },
    watch: {
        title: function (newTitle) {
            this.slug = this.createSlug(newTitle);
        },
        showData: {
            handler(newValue) {
                if (newValue && newValue.data) {
                    const {title, slug, thumbnail, content, description, post_type_id} = newValue.data;
                    this.title = title;
                    this.slug = slug;
                    this.value = JSON.parse(post_type_id);
                    this.imageUrl = thumbnail;
                    this.editorContent = content;
                    this.description = description;
                }
            },
            deep: true,
            immediate: true
        }
    },
    created() {
        this.fetchCategory();
        if (this.$route.params.postsId) {
            this.formType = false;
            this.id = this.$route.params.postsId;
            const postsId = this.$route.params.postsId;
            this.getDetailPosts(postsId);
        } else {
            this.title = '';
            this.slug = '';
            this.imageUrl = null;
            this.value = [];
            this.description = null;
            this.thumbnail = null;
            this.editorContent = null;
            this.formType = true;
        }
    },
    methods: {
        ...mapActions('category', ['fetchCategory',]),
        ...mapActions('posts', ['addPost', 'getOnePost', 'updatePost']),
        createSlug(title) {
            let slug = title.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            slug = slug.toLowerCase().replace(/\s+/g, '-');
            return slug;
        },
        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    this.imageUrl = reader.result;
                    const formData = new FormData();
                    formData.append('upload', file);
                    axios.post('/api/upload-image', formData)
                        .then(response => {
                            this.thumbnail = response.data.url;
                            console.log('File uploaded successfully:', response.data);
                        })
                        .catch(error => {
                            console.error('Error uploading file:', error);
                        });
                };
                reader.readAsDataURL(file);
            }
        },

        addNewPosts(data) {
            this.addPost({data: data, toast: this.$toast})
        },
        updatePosts(data) {
            this.updatePost({data: data, toast: this.$toast})
        },
        getDetailPosts(id) {
            this.getOnePost(id);
        },
        actionBtn(data){
            if (this.formType){
                this.addNewPosts(data);
            }else {
                this.updatePosts(data);
            }
        }
    },
    components: {
        TextEdit,
        Multiselect
    },
    computed: {
        ...mapGetters('category', ['categoryAll']),
        ...mapGetters('posts', ['posts']),
        category() {
            let dataCategory = [];
            for (const item of this.categoryAll) {
                dataCategory.push({
                    value: {
                        id: item.id,
                        name: item.type_name,
                    }, label: item.type_name
                });
            }
            return dataCategory;
        },
        showData() {
            return this.posts;
        },
        getData() {
            return {
                title: this.title,
                slug: this.slug,
                thumbnail: this.thumbnail,
                category: this.value,
                content: this.editorContent,
                description: this.description,
                id: this.id
            }
        }
    },
}
</script>

<style scoped>
.custom-img {
    width: 100%;
    height: 200px;
}

.box-img img {
    width: 100%;
    height: 100%;
    object-fit: contain !important;
}

.box-img {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;
    border: 4px dashed #cccc;
    border-radius: 10px;
}
</style>
