<template>
    <div class="bg" v-if="videos.length > 0">
        <div class="container">
            <div class="title-container">
                <div class="sec-title pt-5 pb-2 text-center"><h2 class="title title2 pb-13"> Tiktok <span style="color: rgb(178, 24, 24);">SMART EDU</span> </h2><div class="heading-border-line"></div></div>
            </div>
            <div class="tiktok-embed-container">
                <div v-for="video in videos" :key="video.id" class="tiktok-embed-item">
                    <!-- embed.js của TikTok tự tải mô tả, hashtag, nhạc từ link -->
                    <blockquote
                        class="tiktok-embed"
                        :cite="video.video_url"
                        :data-video-id="video.video_id"
                        style="max-width: 605px; min-width: 325px;"
                    >
                        <section>
                            <a :href="`https://www.tiktok.com/${video.author_username}`" target="_blank">{{ video.author_username }}</a>
                            {{ video.video_title }}
                        </section>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, nextTick, onMounted, watch } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const videos = computed(() => store.getters['tiktok/tiktokAll']);

// embed.js chỉ quét các blockquote có sẵn lúc nó chạy, nên phải nạp lại mỗi khi danh sách video thay đổi
const loadEmbedScript = () => {
    document.getElementById('tiktok-embed-script')?.remove();
    const script = document.createElement('script');
    script.id = 'tiktok-embed-script';
    script.src = 'https://www.tiktok.com/embed.js';
    script.async = true;
    document.body.appendChild(script);
};

watch(videos, async (newValue) => {
    if (newValue.length > 0) {
        await nextTick();
        loadEmbedScript();
    }
}, { immediate: true });

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
}

/* Responsive cho mobile */
@media (max-width: 768px) {
    .tiktok-embed-item {
        flex: 1 1 100%; /* 1 khối mỗi hàng */
    }
}
blockquote:before{
    display: none;
}
blockquote{
    padding: 0 !important;
}
</style>
