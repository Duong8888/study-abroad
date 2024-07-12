<template>
    <Banner @send-request="sendRequest" :statusBtn="statusBtn" :images="images" :defaultImg="(images.length > 0) ? false : true"></Banner>
    <Introduce></Introduce>
    <Team :items="items"></Team>
    <Universities :items="university"></Universities>
    <template v-for="(item, index) in postsByCategory" :key="item.id">
        <Posts :items="item.posts" :title="category[index].type_name"></Posts>
    </template>
    <!--    <SubBanner></SubBanner>-->
    <AdsBanner :formShow="false"></AdsBanner>
    <Tiktok></Tiktok>
    <Comments></Comments>
</template>

<script>
import Banner from '@/components/Banner.vue';
import Team from '@/components/Team.vue';
import Posts from '@/components/Posts.vue';
import Introduce from '@/components/Introduce.vue';
import Universities from '@/components/Universities.vue';
import SubBanner from '@/components/SubBanner.vue';
import Comments from '@/components/Comments.vue';
import Tiktok from '@/components/TikTokVideo.vue';
import {API_ENDPOINT} from "../store/api-endpoint";
import {mapActions, mapGetters} from "vuex";
import AdsBanner from "@/views/admin/AdsBanner.vue";

export default {
    name: "Home",
    data() {
        return {
            statusBtn: false,
            images: [{image_path: '', link: ''}],
            items: [
                {name: 'Mincin Funo', avatar: ''},
                {name: 'Mincin Funo', avatar: ''},
                {name: 'Mincin Funo', avatar: ''},
            ],
            posts: [],
            category: [],
            university: [],
            postsByCategory: [],
        }
    },
    watch:{
        topBanner: function (newTitle) {
            this.images = newTitle;
        },
        categoryAll: function (newValue){
            this.category = newValue.filter(item => item.status == 1);
            this.fetchPostsByCategory();
        },
        teamAll: function (newValue) {
            this.items = newValue
        },
        postsAll: function (newValue) {
            this.posts = newValue
            console.log(newValue);
            this.$nextTick(() => {
                (this.postsByCategory).push({ posts: this.posts });
            });
        },
        universityAll: function (newValue) {
            this.university = newValue
        },
    },
    computed: {
        ...mapGetters('banner', ['topBanner']),
        ...mapGetters('team', ['teamAll']),
        ...mapGetters('posts', ['postsAll']),
        ...mapGetters('universities', ['universityAll']),
        ...mapGetters('category', ['categoryAll'])
    },
    created() {
        this.fetchBanner(0);
        this.fetchCategory();
        this.fetchTeam();
        this.fetchItem();
    },
    methods: {
        ...mapActions('banner', ['fetchBanner',]),
        ...mapActions('team', ['fetchTeam',]),
        ...mapActions('posts', ['fetchPost',]),
        ...mapActions('universities', ['fetchItem',]),
        ...mapActions('category', ['fetchCategory']),
        fetchPostsByCategory() {
            this.category.forEach(category => {
                this.fetchPost({ sort: category.id, limit: 10 });
            });
        },
        getBanner(){
            this.fetchBanner();
        },
        async sendRequest(value) {
            this.statusBtn = true;
            try {
                const data = await axios.post(API_ENDPOINT.API_USER.SEND_REQUEST, value)
                if (data.data.success) {
                    this.showToast(data.data.message, 'success');
                    this.statusBtn = false;
                }
            } catch (e) {
                if (e.response) {
                    const statusCode = e.response.status;
                    console.log(statusCode);
                    if (statusCode == 429) {
                        this.showToast('Gửi lại yêu cầu său 1 phút', 'error');
                        this.statusBtn = false;
                    }
                    if (statusCode == 422) {
                        this.showToast('Thông tin không hợp lệ', 'error');
                        this.statusBtn = false;
                    }

                }
            }
        },

        showToast(message, type) {
            this.$toast.open({
                message: message,
                type: type,
                position: 'top',
            });
        }
    },
    components: {
        Banner,
        Posts,
        Universities,
        Team,
        Introduce,
        SubBanner,
        Comments,
        AdsBanner,
        Tiktok
    },
}
</script>
