<template>
    <section class="py-12 py-md-16 py-lg-24 position-relative md-pt-60 pt-90 pb-100">
        <div class="position-absolute top-0 start-0 w-100 bg-primary-light">
            <div class="d-flex justify-content-center overflow-hidden pt-lg-24 pb-44 pb-md-64 pb-lg-80">
                <div class="flex-shrink-0 mt-n40 mt-sm-n6 me-6"
                     style="width: 324px; height: 340px; background: linear-gradient(0deg, rgba(255, 234, 194, 0.00) 0%, #b21818 100%);"></div>
                <div class="flex-shrink-0 mt-n40 mt-sm-n32 me-6"
                     style="width: 324px; height: 340px; background: linear-gradient(0deg, rgba(255, 234, 194, 0.00) 0%, #b21818 100%);"></div>
                <div class="flex-shrink-0 mt-n40 mt-sm-n32 me-6"
                     style="width: 324px; height: 340px; background: linear-gradient(0deg, rgba(255, 234, 194, 0.00) 0%, #b21818 100%);"></div>
                <div class="flex-shrink-0 mt-n40 mt-sm-n6"
                     style="width: 324px; height: 340px; background: linear-gradient(0deg, rgba(255, 234, 194, 0.00) 0%, #b21818 100%);"></div>
            </div>
        </div>
        <div class="container position-relative">
            <div class="mw-6xl mx-auto">
                <div class="mw-3xl mx-auto text-center mb-12">
                    <a class="d-inline-flex mb-12 align-items-center text-dark fw-bold mt-12" href="#">
                        <svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="text-white" d="M15.4167 10H5M5 10L10 5M5 10L10 15" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <router-link :to="{name:'PostsList'}">
                            <span class="ms-2 text-white">Back to Blogs</span>
                        </router-link>
                    </a>
                    <div>
                        <span v-if="postsDetail" v-for="item in JSON.parse(postsDetail?.post_type_id)" :key="item"
                              class="badge bg-white mb-4 me-3 text-dark-light fw-medium border border-light rounded-1 mx-1">{{ item.name }}</span>
                    </div>
                    <h3 class="font-heading">{{ postsDetail?.title }}</h3>
                </div>
                <img class="img-fluid d-block mb-12 w-100 rounded" :src="postsDetail?.thumbnail" alt="">
                <div class="d-flex mb-n6 flex-wrap align-items-center justify-content-between py-md-3">
                    <div class="mb-6">
                        <div class="d-flex align-items-center">
                            <img class="img-profile" src="@/assets/images/common/logo.png">
                            <div class="ms-4">
                                <span class="d-block fw-semibold">Admin</span>
                                <span class="text-light-dark fw-medium d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 0.5);transform: ;msFilter:;"><path d="M21 20V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2zM9 18H7v-2h2v2zm0-4H7v-2h2v2zm4 4h-2v-2h2v2zm0-4h-2v-2h2v2zm4 4h-2v-2h2v2zm0-4h-2v-2h2v2zm2-5H5V7h14v2z"></path></svg>
                                    {{ formatDateTime(postsDetail?.created_at) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="d-flex align-items-center flex-wrap mb-n4">
<!--                            <a class="btn btn-sm mb-4 p-1 mr-2 me-4 btn-outline-light text-dark shadow" href="#">Share-->
<!--                                this post</a>-->
                            <div class="mb-4 me-4" @click="copyUrl">
                                <div class="btn d-inline-flex p-1 mr-2 align-items-center btn-sm btn-outline-light text-dark shadow">
                                    <svg width="20" height="20" viewbox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.8334 10.7501V14.2501C12.8334 15.6591 12.5485 16.5153 12.0319 17.0319C11.5153 17.5486 10.6591 17.8334 9.25008 17.8334H5.75008C4.34106 17.8334 3.48482 17.5486 2.96822 17.0319C2.45161 16.5153 2.16675 15.6591 2.16675 14.2501V10.7501C2.16675 9.34106 2.45161 8.48482 2.96822 7.96822C3.48482 7.45161 4.34106 7.16675 5.75008 7.16675H9.25008C10.6591 7.16675 11.5153 7.45161 12.0319 7.96822C12.5485 8.48482 12.8334 9.34106 12.8334 10.7501Z"
                                            fill="#D1D1D1" stroke="#D1D1D1"></path>
                                        <path
                                            d="M14.25 1.66675H10.75C8.2466 1.66675 7.03846 2.5324 6.746 4.61583C6.66858 5.16733 7.13004 5.62508 7.68695 5.62508H9.25005C12.75 5.62508 14.375 7.25008 14.375 10.7501V12.3132C14.375 12.8701 14.8328 13.3315 15.3843 13.2541C17.4677 12.9617 18.3334 11.7535 18.3334 9.25008V5.75008C18.3334 2.83341 17.1667 1.66675 14.25 1.66675Z"
                                            fill="#D1D1D1"></path>
                                    </svg>
                                    <span class="ms-2">Copy link</span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="btn me-3 p-1 mr-2 btn-outline-light shadow" @click="shareOnTwitter">
                                    <svg width="20" height="20" viewbox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.2918 18.1251C13.8371 18.1251 17.9652 11.8724 17.9652 6.45167C17.9652 6.27589 17.9613 6.0962 17.9535 5.92042C18.7566 5.33967 19.4496 4.62033 20 3.7962C19.2521 4.12896 18.458 4.34627 17.6449 4.44074C18.5011 3.92755 19.1421 3.12135 19.4492 2.17159C18.6438 2.64892 17.763 2.98563 16.8445 3.1673C16.2257 2.50976 15.4075 2.07439 14.5164 1.9285C13.6253 1.78261 12.711 1.93433 11.9148 2.3602C11.1186 2.78607 10.4848 3.46238 10.1115 4.28455C9.73825 5.10672 9.64619 6.02897 9.84961 6.9087C8.21874 6.82686 6.62328 6.40321 5.16665 5.6652C3.71002 4.9272 2.42474 3.89132 1.39414 2.62472C0.870333 3.52782 0.710047 4.59649 0.945859 5.61353C1.18167 6.63057 1.79589 7.51966 2.66367 8.10011C2.01219 8.07943 1.37498 7.90402 0.804688 7.58839V7.63917C0.804104 8.58691 1.13175 9.50561 1.73192 10.2391C2.3321 10.9726 3.16777 11.4756 4.09687 11.6626C3.49338 11.8277 2.85999 11.8518 2.2457 11.7329C2.50788 12.548 3.01798 13.2609 3.70481 13.7721C4.39164 14.2833 5.22093 14.5673 6.07695 14.5845C4.62369 15.726 2.82848 16.3452 0.980469 16.3423C0.652739 16.3418 0.325333 16.3217 0 16.2821C1.87738 17.4866 4.06128 18.1263 6.2918 18.1251Z"
                                            fill="#D1D1D1"></path>
                                    </svg>
                                </div>
                                <div class="btn me-3 p-1 mr-2 btn-outline-light shadow" @click="shareOnFacebook">
                                    <svg width="20" height="20" viewbox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_915_35510)">
                                            <path
                                                d="M20 10C20 4.47715 15.5229 0 10 0C4.47715 0 0 4.47715 0 10C0 14.9912 3.65684 19.1283 8.4375 19.8785V12.8906H5.89844V10H8.4375V7.79688C8.4375 5.29063 9.93047 3.90625 12.2146 3.90625C13.3084 3.90625 14.4531 4.10156 14.4531 4.10156V6.5625H13.1922C11.95 6.5625 11.5625 7.3334 11.5625 8.125V10H14.3359L13.8926 12.8906H11.5625V19.8785C16.3432 19.1283 20 14.9912 20 10Z"
                                                fill="#D1D1D1"></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-12 border-bottom"></div>
                <div class="mw-4xl mx-auto show-content container">
                    <div v-if="toc.length" class="toc-container">
                        <h2 @click="tocOpen = !tocOpen">
                            Nội dung chính
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path></svg>
                        </h2>
                        <ul ref="tocList" v-show="tocOpen">
                            <hr>
                            <li v-for="(item, index) in toc" :key="index">
                                <a :href="`#${item.id}`" @click.prevent="scrollToSection(item.id)">{{ item.text }}</a>
                                <ul v-if="item.children && item.children.length">
                                    <li v-for="(child, childIndex) in item.children" :key="childIndex">
                                        <a :href="`#${child.id}`" @click.prevent="scrollToSection(child.id)">{{ child.text }}</a>
                                        <ul v-if="child.children && child.children.length">
                                            <li v-for="(grandChild, grandChildIndex) in child.children" :key="grandChildIndex">
                                                <a :href="`#${grandChild.id}`" @click.prevent="scrollToSection(grandChild.id)">{{ grandChild.text }}</a>
                                                <ul v-if="grandChild.children && grandChild.children.length">
                                                    <li v-for="(greatGrandChild, greatGrandChildIndex) in grandChild.children" :key="greatGrandChildIndex">
                                                        <a :href="`#${greatGrandChild.id}`" @click.prevent="scrollToSection(greatGrandChild.id)">{{ greatGrandChild.text }}</a>
                                                        <ul v-if="greatGrandChild.children && greatGrandChild.children.length">
                                                            <li v-for="(greatGreatGrandChild, greatGreatGrandChildIndex) in greatGrandChild.children" :key="greatGreatGrandChildIndex">
                                                                <a :href="`#${greatGreatGrandChild.id}`" @click.prevent="scrollToSection(greatGreatGrandChild.id)">{{ greatGreatGrandChild.text }}</a>
                                                                <ul v-if="greatGreatGrandChild.children && greatGreatGrandChild.children.length">
                                                                    <li v-for="(greatGreatGreatGrandChild, greatGreatGreatGrandChildIndex) in greatGreatGrandChild.children" :key="greatGreatGreatGrandChildIndex">
                                                                        <a :href="`#${greatGreatGreatGrandChild.id}`" @click.prevent="scrollToSection(greatGreatGreatGrandChild.id)">{{ greatGreatGreatGrandChild.text }}</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="my-5" v-html="postsDetail?.university_info"></div>
                    <div class="responsive-table" v-html="postsDetail?.content"></div>
                </div>
            </div>
        </div>

        <Posts :items="postsList" :title="title"></Posts>
    </section>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Posts from '@/components/Posts.vue';

export default {
    name: "PostsDetail",
    components:{
        Posts
    },
    data() {
        return {
            postsDetail: {
                slug: "posts",
                thumbnail: 'hello',
                title: 'hello',
                content: 'hello',
                created_at: null,
                post_type_id: '[{"id": 1, "name": "2"}]',
            },
            slug: null,
            postsList: [],
            title:"Bài viết liên quan",
            toc: [],
            tocOpen: true,
        }
    },
    methods: {
        ...mapActions('posts', ['getOnePost','fetchPost']),
        async getData(slug) {
            await this.getOnePost(slug);
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
            // return `${hours}:${minutes} ${day}/${month}/${year}`;
            return `${day}/${month}/${year}`;
        },
        shareOnFacebook() {
            const url = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href);
            window.open(url, '_blank');
        },
        shareOnTwitter() {
            const url = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href);
            window.open(url, '_blank');
        },
        async copyUrl() {
            try {
                const url = window.location.href;
                await navigator.clipboard.writeText(url);
                this.$toast.open({
                    message: 'Copy thành công',
                    type: 'success',
                    position: 'top',
                });
            } catch (error) {
                console.error("Failed to copy URL:", error);
            }
        },
        addOverflowXToTables() {
            const tables = this.$el.querySelectorAll('table');
            const maxColumns = window.innerWidth <= 768 ? 4 : 8;
            tables.forEach((table) => {
                const columns = table.querySelectorAll('th, td');
                const numColumns = columns.length / table.querySelectorAll('tr').length;

                if (numColumns > maxColumns)  {
                    table.style.display = "block";
                    table.style.overflowX = "auto";
                }
            });
        },
        generateToc() {
            const contentDiv = this.$el.querySelector('.responsive-table');
            const headings = contentDiv.querySelectorAll('h1, h2, h3, h4, h5, h6');

            this.toc = [];

            let tocData = [];
            let tocStack = [];
            let numberStack = [];

            headings.forEach((heading) => {
                const hLevel = parseInt(heading.tagName.substring(1));
                const titleText = heading.innerText.trim();
                let id = heading.id || titleText.replace(/\s+/g, '-').toLowerCase();
                heading.id = id;
                numberStack[hLevel - 1] = (numberStack[hLevel - 1] || 0) + 1;
                numberStack.fill(0, hLevel);
                const number = numberStack.slice(0, hLevel).join('.');
                const tocItem = {
                    id: id,
                    text: titleText,
                    level: hLevel,
                    children: [],
                    number: number,
                };
                if (tocStack.length === 0) {
                    tocData.push(tocItem);
                } else {
                    while (tocStack.length > 0 && tocStack[tocStack.length - 1].level >= hLevel) {
                        tocStack.pop();
                    }
                    if (tocStack.length > 0) {
                        tocStack[tocStack.length - 1].children.push(tocItem);
                    } else {
                        tocData.push(tocItem);
                    }
                }

                tocStack.push(tocItem);
            });
            this.toc = tocData;
        },
        scrollToSection(id) {
            const targetElement = document.getElementById(id);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 50,
                    behavior: 'smooth',
                });
            }
        }
    },
    updated() {
        this.addOverflowXToTables();
    },
    computed: {
        ...mapGetters('posts', ['posts','postsAll']),
    },
    watch: {
        posts: {
            async handler(newVal) {
                this.postsDetail = newVal.data;
                if (newVal) {
                    await this.$nextTick(() => {
                        this.generateToc();
                    });
                }
                if(this.postsDetail?.post_type_id){
                    var typeList = [];
                    var data = JSON.parse(this.postsDetail?.post_type_id);
                    for (var i = 0; i < data.length; i++){
                        typeList.push(data[i].id);
                    }
                }
                await this.fetchPost(typeList);
            },
            immediate: true
        },
        postsAll: function (newValue) {
            this.postsList = newValue
        },
    },
    created() {
        this.slug = this.$route.params.slug;
        this.getData(this.slug);
    },
}
</script>

<style scoped>
.responsive-table >>> table td{
    padding: 10px 30px;
}
.responsive-table >>> table {
    width: 100%;
    overflow-x: auto;
}
@media only screen and (max-width: 600px) {
    .responsive-table >>> table td{
        padding: 5px 20px;
    }
    .responsive-table >>> table {
        width: 100%;
        display: block;
    }
}

/* CSS để tạo mục lục */
.toc-container {
    margin-top: 20px;
    top: 0;
    right: 0;
    width: 100%;
    padding: 10px;
    border: 1px solid #b21818;
    background-color: #f9f9f9;
    z-index: 1000;
}

hr{
    border: 1px solid #b21818;
}

.toc-container h2 {
    color: #b21818;
    font-size: 25px;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.toc-container ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.toc-container li {
    margin: 0;
    padding: 0;
    position: relative;
}

.toc-container li a {
    text-decoration: none;
    display: block;
    padding: 0.5em 0;
    margin-left: 0;
    color: #b21818;
}
.toc-container li a:hover{
    text-decoration: underline !important;
    color: #b21818;
}

.toc-container li a.active {
    font-weight: bold;
    color: #42b983;
}

.toc-container ul ul {
    padding-left: 20px;
}

.toc-container ul ul ul {
    padding-left: 20px;
}

.toc-container ul ul ul ul {
    padding-left: 20px;
}

.toc-container ul ul ul ul ul {
    padding-left: 20px;
}

.toc-container ul ul ul ul ul ul {
    padding-left: 20px;
}

.toc-container ul ul ul ul ul ul ul {
    padding-left: 20px;
}

.responsive-table {
    overflow: auto;
}
.img-profile {
    width: 50px;
    margin-right: 10px;
}
</style>
