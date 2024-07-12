<template>
    <div class="bg">
        <div class="container">
            <div class="title-container">
                <div class="sec-title pt-5 pb-2 text-center"><h2 class="title title2 pb-13"> Tiktok <span style="color: rgb(178, 24, 24);">SMART EDU</span> </h2><div class="heading-border-line"></div></div>
            </div>
            <div class="tiktok-embed-container">
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
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';

// Dữ liệu video TikTok
const videos = [
    {
        url: 'https://www.tiktok.com/@du.hc.smartedu/video/7384067532929518865',
        videoId: '7384067532929518865',
        userProfile: 'https://www.tiktok.com/@du.hc.smartedu',
        userName: '@du.hc.smartedu',
        description: 'Chia Sẻ Kinh Nghiệm Du Học Hàn Quốc',
        tags: [
            { title: '#DuhocSmartEdu', url: 'https://www.tiktok.com/tag/duhocsmartedu?refer=embed' },
            { title: '#duhochanquoc🇰🇷', url: 'https://www.tiktok.com/tag/duhochanquoc%F0%9F%87%B0%F0%9F%87%B7?refer=embed' },
            { title: '#xuhuong', url: 'https://www.tiktok.com/tag/xuhuong?refer=embed' },
            { title: '#viral', url: 'https://www.tiktok.com/tag/viral?refer=embed' },
        ],
        musicUrl: 'https://www.tiktok.com/music/Vlog---Stylish-city-pop-1275391-7200478944389564418?refer=embed',
        musicTitle: '♬ Vlog ・ Stylish city pop(1275391) - orino',
    },
    {
        url: 'https://www.tiktok.com/@du.hc.smartedu/video/7378117177376836881',
        videoId: '7378117177376836881',
        userProfile: 'https://www.tiktok.com/@du.hc.smartedu',
        userName: '@du.hc.smartedu',
        description: 'Ai Hiểu Biết Về Điện Ảnh Và Ẩm Thực Của Hàn Quốc Hơn',
        tags: [
            { title: '#DuhocSmartEdu', url: 'https://www.tiktok.com/tag/duhocsmartedu?refer=embed' },
            { title: '#hanquoc', url: 'https://www.tiktok.com/tag/hanquoc?refer=embed' },
            { title: '#vanhoahanquoc', url: 'https://www.tiktok.com/tag/vanhoahanquoc?refer=embed' },
            { title: '#duhochanquoc', url: 'https://www.tiktok.com/tag/duhochanquoc?refer=embed' },
            { title: '#duhocsinhhanquoc', url: 'https://www.tiktok.com/tag/duhocsinhhanquoc?refer=embed' },
        ],
        musicUrl: 'https://www.tiktok.com/music/Very-cute-melody-by-marimba-tone-39813-6849968592285337602?refer=embed',
        musicTitle: '♬ Very cute melody by marimba tone(39813) - Mitsu Sound',
    },
    {
        url: 'https://www.tiktok.com/@du.hc.smartedu/video/7379230454425193729',
        videoId: '7379230454425193729',
        userProfile: 'https://www.tiktok.com/@du.hc.smartedu',
        userName: '@du.hc.smartedu',
        description: 'Con Trai Thì Nên Học Ngành Gì Tại Hàn Quốc',
        tags: [
            { title: '#DuhocSmartEdu', url: 'https://www.tiktok.com/tag/duhocsmartedu?refer=embed' },
            { title: '#hanquoc', url: 'https://www.tiktok.com/tag/hanquoc?refer=embed' },
            { title: '#duhochanquoc', url: 'https://www.tiktok.com/tag/duhochanquoc?refer=embed' },
            { title: '#duhocsinhhanquoc', url: 'https://www.tiktok.com/tag/duhocsinhhanquoc?refer=embed' },
            { title: '#duhochanquoc🇰🇷', url: 'https://www.tiktok.com/tag/duhochanquoc%F0%9F%87%B0%F0%9F%87%B7?refer=embed' },
        ],
        musicUrl: 'https://www.tiktok.com/music/Thuyền-Không-Bến-Đợi-feat-Czee-7321338716034746369?refer=embed',
        musicTitle: '♬ Thuyền Không Bến Đợi (feat. Czee) - Trungg I.U',
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
