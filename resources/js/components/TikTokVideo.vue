<template>
    <div class="container tiktok-embed-container">
        <div v-for="(video, index) in videos" :key="index" class="tiktok-embed-item">
            <blockquote
                class="tiktok-embed"
                :cite="video.url"
                :data-video-id="video.videoId"
                style="max-width: 605px; min-width: 325px;"
            >
                <section>
                    <a :href="video.userProfile" target="_blank" :title="video.userName">{{ video.userName }}</a>
                    {{ video.description }}
                    <a v-for="(tag, idx) in video.tags" :key="idx" :href="tag.url" target="_blank" :title="tag.title">{{ tag.title }}</a>
                    <a :href="video.musicUrl" target="_blank" :title="video.musicTitle">{{ video.musicTitle }}</a>
                </section>
            </blockquote>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';

// Dữ liệu video TikTok
const videos = [
    {
        url: 'https://www.tiktok.com/@smarteduchuyn.du/video/7364801746012507410',
        videoId: '7364801746012507410',
        userProfile: 'https://www.tiktok.com/@smarteduchuyn.du',
        userName: '@smarteduchuyn.du',
        description: 'Các từ ghép dễ nhớ dành cho các bạn mới bắt đầu học tiếng hàn🌼',
        tags: [
            { title: '#tugheptienghan', url: 'https://www.tiktok.com/tag/tugheptienghan?refer=embed' },
            { title: '#hoctienghan', url: 'https://www.tiktok.com/tag/hoctienghan?refer=embed' },
            { title: '#duhochanquoc', url: 'https://www.tiktok.com/tag/duhochanquoc?refer=embed' },
            { title: '#hanquocbiettuot', url: 'https://www.tiktok.com/tag/hanquocbiettuot?refer=embed' },
        ],
        musicUrl: 'https://www.tiktok.com/music/nhạc-nền-𝙺𝚊𝚛𝚒𝚝𝚎𝚗-🧚‍♀️-7114260815423130395?refer=embed',
        musicTitle: '♬ nhạc nền - 𝙺𝚊𝚛𝚒𝚝𝚎𝚟-krin•htt',
    },
    {
        url: 'https://www.tiktok.com/@smarteduchuyn.du/video/7367021187509128455',
        videoId: '7367021187509128455',
        userProfile: 'https://www.tiktok.com/@smarteduchuyn.du',
        userName: '@smarteduchuyn.du',
        description: 'Học từ vựng mỗi ngày nha🥰',
        tags: [
            { title: '#hoctienghanmoingay', url: 'https://www.tiktok.com/tag/hoctienghanmoingay?refer=embed' },
            { title: '#duhochanquoc', url: 'https://www.tiktok.com/tag/duhochanquoc?refer=embed' },
            { title: '#smartedu', url: 'https://www.tiktok.com/tag/smartedu?refer=embed' },
            { title: '#hoctienghan', url: 'https://www.tiktok.com/tag/hoctienghan?refer=embed' },
        ],
        musicUrl: 'https://www.tiktok.com/music/original-sound-핸-6920524488874445570?refer=embed',
        musicTitle: '♬ original sound - 핸 - 🧃',
    },
    {
        url: 'https://www.tiktok.com/@smarteduchuyn.du/video/7365154218711272712?_r=1&_t=8mkQxX6ywT4',
        videoId: '7365154218711272712',
        userProfile: 'https://www.tiktok.com/@smarteduchuyn.du',
        userName: '@smarteduchuyn.du',
        description: 'Bí quyết học từ vựng tiếng Hàn hiệu quả 🌟',
        tags: [
            { title: '#hoctienghan', url: 'https://www.tiktok.com/tag/hoctienghan?refer=embed' },
            { title: '#duhochanquoc', url: 'https://www.tiktok.com/tag/duhochanquoc?refer=embed' },
            { title: '#hanquocbiettuot', url: 'https://www.tiktok.com/tag/hanquocbiettuot?refer=embed' },
            { title: '#tuvungtienghan', url: 'https://www.tiktok.com/tag/tuvungtienghan?refer=embed' },
        ],
        musicUrl: 'https://www.tiktok.com/music/nhạc-nền-𝙺𝚊𝚛𝚒𝚝𝚎𝚝-🧚‍♀️-7114260815423130395?refer=embed',
        musicTitle: '♬ nhạc nền - 𝙺𝚊𝚛𝚒𝚝𝚎𝚟-krin•htt',
    },
];

onMounted(() => {
    const script = document.createElement('script');
    script.src = 'https://www.tiktok.com/embed.js';
    script.async = true;
    document.body.appendChild(script);
});
</script>

<style scoped>
.tiktok-embed-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
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
