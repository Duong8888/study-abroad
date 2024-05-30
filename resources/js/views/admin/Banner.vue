<template>
    <div class="container">
        <div class="d-flex justify-content-end">
            <router-link :to="{name:'EditBanner',query: { type: 'top' }}">
                <button class="btn btn-outline-secondary float-right mr-2">Chỉnh sửa banner banner</button>
            </router-link>
            <router-link :to="{name:'AddBanner',query: { type: 'top' }}">
                <button class="btn btn-outline-primary float-right">Thêm mới banner</button>
            </router-link>
        </div>
        <hr>
        <BannerView :images="images" :defaultImg="(images.length > 0) ? false : true" :form="false"></BannerView>
    </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import BannerView from '@/components/Banner.vue';

export default {
    data() {
        return {
            images: [{image_path: '', link: ''}],
        };
    },
    components: {
        BannerView,
    },
    watch:{
        bannerAll: function (newTitle) {
            this.images = newTitle;
        },
    },
    computed: {
        ...mapGetters('banner', ['bannerAll']),
    },

    methods: {
        ...mapActions('banner', ['fetchBanner',]),
    },
    created() {
        this.fetchBanner(0);
    },

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
</style>
