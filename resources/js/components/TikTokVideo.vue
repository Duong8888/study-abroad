<template>
    <div class="bg" v-if="videos.length > 0">
        <div class="container">
            <div class="title-container">
                <div class="sec-title pt-5 pb-2 text-center"><h2 class="title title2 pb-13"> Tiktok <span style="color: rgb(178, 24, 24);">SMART EDU</span> </h2><div class="heading-border-line"></div></div>
            </div>
            <div class="tiktok-embed-container">
                <div v-for="video in videos" :key="video.id" class="tiktok-embed-item">
                    <!-- Nhúng thẳng iframe, loading="lazy" để chỉ tải khi cuộn tới, tránh bị TikTok chặn vì gọi quá nhiều -->
                    <iframe
                        class="tiktok-iframe"
                        :src="`https://www.tiktok.com/embed/v2/${video.video_id}`"
                        :title="video.video_title || video.author_username"
                        loading="lazy"
                        allow="encrypted-media; fullscreen"
                        allowfullscreen
                        frameborder="0"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const videos = computed(() => store.getters['tiktok/tiktokAll'].filter(video => video.video_id));

onMounted(() => {
    store.dispatch('tiktok/fetchTiktok');
});
</script>

<style scoped>
.tiktok-embed-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.bg{
    background: #fbefef;
    margin-top: 40px;
}

.tiktok-embed-item {
    flex: 1 1 calc(33.333% - 10px); /* 3 khối mỗi hàng */
    box-sizing: border-box;
    display: flex;
    justify-content: center;
    padding-bottom: 20px;
}
.tiktok-iframe {
    width: 100%;
    max-width: 325px;
    height: 740px; /* chiều cao chuẩn của khung video TikTok */
    border-radius: 8px;
    background: #fff;
}

/* Responsive cho mobile */
@media (max-width: 768px) {
    .tiktok-embed-item {
        flex: 1 1 100%; /* 1 khối mỗi hàng */
    }
}
</style>
