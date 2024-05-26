<template>
    <div className="container">
        <div className="card shadow mb-4">
            <div className="card-header py-3">
                <h6 className="m-0 font-weight-bold text-primary">Create posts</h6>
            </div>
            <div className="row p-4">
                <div className="col-12">
                    <div className="w-100">
                        <label htmlFor="inputTitle" className="form-label">Title</label>
                        <input type="text" className="form-control mb-20" id="inputTitle" placeholder="Title"
                               v-model="title" aria-label="Title">
                    </div>
                    <div className="w-100">
                        <label htmlFor="inputSlug" className="form-label">Slug</label>
                        <input type="text" className="form-control mb-20" id="inputSlug" placeholder="Slug"
                               v-model="slug"
                               aria-label="Slug">
                    </div>

                    <div className="w-100 mb-20">
                        <label htmlFor="inputSlug" className="form-label">Category</label>
                        <Multiselect class="form-label"
                                     v-model="value"
                                     mode="tags"
                                     :close-on-select="false"
                                     :searchable="true"
                                     :create-option="true"
                                     :options="options"
                        />
                    </div>
                </div>
            </div>
            <div className="px-4 col-12">
                <TextEdit></TextEdit>
            </div>
            <div className="col-12">
                <input hidden type="file" className="form-control" id="imageInput" ref="imageInput"
                       @change="previewImage"
                       accept="image/*">
                <label htmlFor="imageInput" className="form-label box-img">
                    <p v-if="!imageUrl" className="d-flex flex-column align-items-center justify-content-center">
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
            <div className="col-12 py-4 d-flex justify-content-end">
                <button className="btn btn-light mx-1">Edit</button>
                <button className="btn btn-primary">View</button>
            </div>
        </div>
    </div>
</template>

<script>
import TextEdit from '../../components/admin/TextEdit.vue';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';

export default {
    name: "PostsAdd",
    data() {
        return {
            title: '',
            slug: '',
            imageUrl: null,
            value: null,
            options: [
                {value: 'batman', label: 'Batman'},
                {value: 'robin', label: 'Robin'},
                {value: 'joker', label: 'Joker'},
            ]
        };
    },
    watch: {
        title: function (newTitle) {
            this.slug = this.createSlug(newTitle);
        }
    },
    methods: {
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
                };
                reader.readAsDataURL(file);
            }
        }
    },
    components: {
        TextEdit,
        Multiselect
    },
    computed: {},
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
