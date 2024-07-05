<template>
    <section class="py-12 py-md-16 py-lg-24 pt-100">
        <div class="container mb-50">
            <div class="mw-6xl mx-auto">
                <h2 class="font-heading mb-6">Blog</h2>
                <p class="fs-5 text-light-dark mb-24">Các bài viết và bản phát hành mới nhất</p>
                <a class="d-block mb-20 p-4 bg-white mb-20 border rounded-3" href="#">
                    <div class="rounded-3">
                        <router-link :to="{name: 'PostsDetail', params: {slug: postsNew?.slug}}">
                            <div class="row">
                                <div class="position-relative col-12 col-md-6 p-0 rounded-3 overflow-hidden">
                                    <img class="img-fluid d-block h-100 w-100" :src="postsNew?.thumbnail"
                                         alt="">
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex flex-col h-100 align-items-center">
                                        <div class="mw-md mx-auto py-8 px-8">
                                            <h4 class="mb-4">{{ postsNew?.title }}</h4>
                                            <p class="text-light-dark mb-10 description">{{ postsNew?.description }}</p>
                                            <div>
                                            <span
                                                class="me-3 small text-light-dark">{{
                                                    formatDateTime(postsNew?.created_at)
                                                }}</span>
                                                <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="2" cy="2" r="2" fill="#B8B8B8"></circle>
                                                </svg>
                                                <span v-for="category in JSON.parse(postsNew?.post_type_id)"
                                                      :key="category"
                                                      class="badge ms-3 small fw-medium text-light-dark border mr-2">{{
                                                        category.name
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </a>
                <h4 class="mb-10" id="main-home">Bài viết mới nhất</h4>
                <ul class="nav mb-5">
                    <li><a data-toggle="tab" href="#home" @click="getData()">
                        <button type="button" class="btn-custom mr-2 mb-2">Tất cả bài viết</button>
                    </a></li>
                    <li v-for="(item,index) in category" :key="item"><a data-toggle="tab" :href="'#menu'+(index+1)">
                        <button type="button" @click="getData(item.id)" class="btn-custom mr-2 mb-2">{{ item?.type_name }}</button>
                    </a></li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <div class="row mb-n8">
                            <div class="col-12 col-sm-6 col-lg-4 mb-8" v-for="item in paginatedItems" :key="item">
                                <router-link :to="{name: 'PostsDetail', params: {slug: item?.slug}}">
                                    <div class="card p-3 h-100 overflow-hidden item-posts">
                                        <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                            <img class="card-img-top rounded-0" :src="item?.thumbnail"
                                                 alt="...">
                                        </div>
                                        <div class="card-body d-flex flex-column align-items-start mw-xs">
                                            <h6 class="card-title mb-3">{{ item?.title }}</h6>
                                            <p class="card-text small text-light-dark mb-6 description">
                                                {{ item?.description }}</p>
                                            <div class="mt-auto">
                                                <span
                                                    class="me-3 small text-light-dark date">{{
                                                        formatDateTime(item?.created_at)
                                                    }}</span>
                                                <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                                </svg>
                                                <span v-for="category in JSON.parse(item?.post_type_id)" :key="category"
                                                      class="badge ms-3 small fw-medium text-light-dark border mr-2 category">{{
                                                        category.name
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>

                    <div v-for="(item,index) in category" :key="item" :id="'menu'+(index+1)" class="tab-pane fade">
                        <div class="row mb-n8">
                            <div class="col-12 col-sm-6 col-lg-4 mb-8" v-for="item in paginatedItems" :key="item">
                                <router-link :to="{name: 'PostsDetail', params: {slug: item?.slug}}">
                                    <div class="card p-3 h-100 overflow-hidden item-posts">
                                        <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                            <img class="card-img-top rounded-0" :src="item?.thumbnail"
                                                 alt="...">
                                        </div>
                                        <div class="card-body d-flex flex-column align-items-start mw-xs">
                                            <h6 class="card-title mb-3">{{ item?.title }}</h6>
                                            <p class="card-text small text-light-dark mb-6 description">
                                                {{ item?.description }}</p>
                                            <div class="mt-auto">
                                                <span
                                                    class="me-3 small text-light-dark date">{{
                                                        formatDateTime(item?.created_at)
                                                    }}</span>
                                                <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                                </svg>
                                                <span v-for="category in JSON.parse(item?.post_type_id)" :key="category"
                                                      class="badge ms-3 small fw-medium text-light-dark border mr-2 category">{{
                                                        category.name
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <Pagination
        v-if="postsList.length > 0"
        :totalItems="postsList.length"
        :itemsPerPage="itemsPerPage"
        v-model:currentPage="currentPage"
    />
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import Pagination from '../components/Pagination.vue';

export default {
    name: "PostsList",
    data() {
        return {
            postsList: [
                {
                    slug: "posts",
                    thumbnail: null,
                    title: null,
                    created_at: null,
                    post_type_id: '[{"id": 1, "name": "posts"}]',
                }
            ],
            category: [],
            postsNew: {
                slug: "posts",
                thumbnail: null,
                title: null,
                created_at: null,
                post_type_id: '[{"id": null, "name": null}]',
            },
            itemsPerPage: 6,
            currentPage: 1
        }
    },
    components:{
        Pagination
    },
    methods: {
        ...mapActions('posts', ['fetchPost']),
        ...mapActions('category', ['fetchCategory']),
        async getData(sort = null) {
            await this.fetchPost(sort);
            this.currentPage = 1;
        },
        async getDataCategory() {
            await this.fetchCategory();
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
            return `${hours}:${minutes} ${day}/${month}/${year}`;
        },
    },
    computed: {
        ...mapGetters('category', ['categoryAll']),
        ...mapGetters('posts', ['postsAll']),
        paginatedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.postsList.slice(start, end);
        }
    },
    watch: {
        postsAll: {
            handler(newVal) {
                this.postsList = newVal.slice();
                if (this.postsList.length > 0) {
                    this.postsList.shift();
                    this.postsNew = newVal[0];
                }
            },
            immediate: true
        },
        categoryAll: {
            handler(newVal) {
                this.category = newVal;
            },
            immediate: true
        },
    },
    created() {
        this.getData();
        this.getDataCategory();
    },
}
</script>

<style scoped>
p, span {
    color: #0b0b0b;
}

.active button {
    color: #fff;
    background-color: #be1510;
    border-color: #be1510;
}
.btn-custom{
    padding: 5px 10px;
    border-radius: 5px;
    outline: none;
    background: white;
    border: 1px solid #be1510;
    color: #be1510;
}

.card-img-top {
    height: 100%;
    object-fit: cover;
    border-radius: 3px !important;
}

.img-fluid {
    object-fit: cover !important;
    width: 100%;
    height: 200px !important;
    border-radius: 5px;
}

.description {
    font-size: 14px;
    margin: 0;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    white-space: normal;
    text-overflow: ellipsis;
    width: 100%;
}
.item-posts{
    transition: 0.5s;
}
.item-posts:hover{
    background: #be1510 !important;
}

.item-posts:hover .card-text{
    color: white !important;
}

.item-posts:hover .card-title{
    color: white !important;
    text-decoration: underline;
}

.item-posts:hover .date,.item-posts:hover .category{
    color: white !important;
}
</style>
