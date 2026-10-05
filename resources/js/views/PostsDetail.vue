<template>
    <article class="post-page">
        <header class="post-hero">
            <div class="post-container post-hero__inner">
                <nav class="post-breadcrumb" aria-label="breadcrumb">
                    <router-link :to="{name: 'Home'}">Trang chủ</router-link>
                    <span class="sep">/</span>
                    <router-link :to="{name: 'PostsList'}">Tin tức</router-link>
                    <template v-if="categories.length">
                        <span class="sep">/</span>
                        <span class="current">{{ categories[0].name }}</span>
                    </template>
                </nav>

                <template v-if="postsDetail">
                    <div class="post-cats">
                        <span v-for="item in categories" :key="item.id" class="post-cat">{{ item.name }}</span>
                    </div>
                    <h1 class="post-title">{{ postsDetail.title }}</h1>
                    <p v-if="postsDetail.description" class="post-lead">{{ postsDetail.description }}</p>

                    <div class="post-meta">
                        <div class="post-author">
                            <img v-if="logoMain" class="post-author__avatar" :src="logoMain" alt="SMART EDU">
                            <div>
                                <div class="post-author__name">SMART EDU</div>
                                <div class="post-author__info">
                                    <span><i class="far fa-calendar-alt"></i> {{ formatDateTime(postsDetail.created_at) }}</span>
                                    <span class="dot">·</span>
                                    <span><i class="far fa-clock"></i> {{ readingTime }} phút đọc</span>
                                </div>
                            </div>
                        </div>
                        <div class="post-share">
                            <button type="button" class="share-btn" title="Chia sẻ Facebook" @click="shareOnFacebook">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button type="button" class="share-btn" title="Chia sẻ Twitter" @click="shareOnTwitter">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button type="button" class="share-btn share-btn--text" title="Sao chép liên kết" @click="copyUrl">
                                <i class="fas fa-link"></i> <span>Sao chép link</span>
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Khung chờ khi đang tải -->
                <div v-else class="post-skeleton" aria-hidden="true">
                    <div class="sk sk-pill"></div>
                    <div class="sk sk-title"></div>
                    <div class="sk sk-title short"></div>
                    <div class="sk sk-line"></div>
                </div>
            </div>
        </header>

        <div class="post-container">
            <figure v-if="postsDetail?.thumbnail" class="post-cover">
                <img :src="postsDetail.thumbnail" :alt="postsDetail.title">
            </figure>
            <div v-else-if="!postsDetail" class="post-cover sk"></div>

            <PostArticle :content="postsDetail?.content || ''"
                         :university-info="postsDetail?.university_info || ''"></PostArticle>

            <div v-if="postsDetail" class="post-footer-share">
                <span>Thấy bài viết hữu ích? Chia sẻ ngay:</span>
                <div class="post-share">
                    <button type="button" class="share-btn" title="Chia sẻ Facebook" @click="shareOnFacebook">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button type="button" class="share-btn" title="Chia sẻ Twitter" @click="shareOnTwitter">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button type="button" class="share-btn share-btn--text" title="Sao chép liên kết" @click="copyUrl">
                        <i class="fas fa-link"></i> <span>Sao chép link</span>
                    </button>
                </div>
            </div>
        </div>

        <Posts v-if="postsList.length" :items="postsList" :title="title"></Posts>
    </article>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Posts from '@/components/Posts.vue';
import PostArticle from '@/components/PostArticle.vue';

export default {
    name: "PostsDetail",
    components:{
        Posts,
        PostArticle,
    },
    data() {
        return {
            postsDetail: null,
            title:"Bài viết liên quan",
        }
    },
    methods: {
        ...mapActions('posts', ['getOnePost','fetchPost','clearPost']),
        async getData(slug) {
            this.clearPost();
            await this.getOnePost(slug);
        },
        formatDateTime(dateTimeStr) {
            if (!dateTimeStr) return '';
            return new Date(dateTimeStr).toLocaleDateString('vi-VN', {
                timeZone: 'Asia/Ho_Chi_Minh',
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            });
        },
        shareOnFacebook() {
            const url = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(this.shareUrl());
            window.open(url, '_blank');
        },
        shareOnTwitter() {
            const url = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(this.shareUrl());
            window.open(url, '_blank');
        },
        shareUrl() {
            // Bỏ phần #muc-luc khỏi link chia sẻ
            return window.location.href.split('#')[0];
        },
        async copyUrl() {
            try {
                await navigator.clipboard.writeText(this.shareUrl());
                this.$toast.open({
                    message: 'Copy thành công',
                    type: 'success',
                    position: 'top',
                });
            } catch (error) {
                console.error("Failed to copy URL:", error);
            }
        },
    },
    computed: {
        ...mapGetters('posts', ['posts','postsAll']),
        ...mapGetters('settings', ['logoMain']),
        categories() {
            try {
                return JSON.parse(this.postsDetail?.post_type_id || '[]');
            } catch (e) {
                return [];
            }
        },
        readingTime() {
            const text = (this.postsDetail?.content || '').replace(/<[^>]*>/g, ' ').replace(/&nbsp;/g, ' ').trim();
            const words = text ? text.split(/\s+/).length : 0;
            return Math.max(1, Math.round(words / 200));
        },
        postsList() {
            // Bài viết liên quan: bỏ chính bài đang xem
            const list = Array.isArray(this.postsAll) ? this.postsAll : [];
            return list.filter(item => item.slug !== this.postsDetail?.slug);
        },
    },
    watch: {
        posts(newVal) {
            this.postsDetail = newVal?.data || null;
            if (this.postsDetail) {
                document.title = this.postsDetail.title;
                const typeList = this.categories.map(item => item.id);
                if (typeList.length) {
                    this.fetchPost(typeList);
                }
            }
        },
        '$route.params.slug': {
            handler(slug) {
                if (slug) {
                    this.getData(slug);
                    window.scrollTo(0, 0);
                }
            },
            immediate: true,
        },
    },
}
</script>

<style scoped>
.post-page {
    --brand: #b21818;
    background: #fff;
}
.post-container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 20px;
}

/* ---------- Phần đầu ---------- */
.post-hero {
    padding: 120px 0 36px;
    background: linear-gradient(180deg, #fdf3f3 0%, #fff 100%);
}
.post-title,
.post-lead {
    max-width: 880px;
}
.post-breadcrumb {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    font-size: 14px;
    color: #6b7280;
}
.post-breadcrumb a {
    color: #6b7280;
}
.post-breadcrumb a:hover {
    color: var(--brand);
}
.post-breadcrumb .sep {
    color: #c4c4c4;
}
.post-breadcrumb .current {
    color: var(--brand);
    font-weight: 600;
}
.post-cats {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 14px;
}
.post-cat {
    padding: 4px 12px;
    border-radius: 999px;
    background: var(--brand);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    line-height: 1.6;
    letter-spacing: .04em;
    text-transform: uppercase;
}
.post-title {
    margin: 0 0 16px;
    font-family: 'Montserrat', 'Open Sans', Arial, sans-serif;
    font-size: 40px;
    font-weight: 700;
    line-height: 1.25;
    letter-spacing: -0.02em;
    color: #1b1f23;
}
.post-lead {
    margin: 0 0 24px;
    font-family: 'Open Sans', Arial, sans-serif;
    font-size: 19px;
    line-height: 1.65;
    color: #4b5563;
}
.post-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding-top: 20px;
    border-top: 1px solid #f0e2e2;
}
.post-author {
    display: flex;
    align-items: center;
    gap: 12px;
}
.post-author__avatar {
    width: 48px;
    height: 48px;
    padding: 4px;
    border-radius: 50%;
    border: 1px solid #f0e2e2;
    background: #fff;
    object-fit: contain;
}
.post-author__name {
    font-weight: 700;
    color: #1b1f23;
    line-height: 1.3;
}
.post-author__info {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: #6b7280;
    line-height: 1.5;
}
.post-author__info i {
    margin-right: 3px;
}
.post-share {
    display: flex;
    gap: 8px;
}
.share-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    border: 1px solid #e5e7eb;
    border-radius: 999px;
    background: #fff;
    color: #4b5563;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s;
}
.share-btn:hover {
    border-color: var(--brand);
    background: var(--brand);
    color: #fff;
}

/* ---------- Ảnh bìa ---------- */
.post-cover {
    margin: 8px 0 40px;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 18px 40px -20px rgba(0, 0, 0, .35);
    aspect-ratio: 16 / 9;
    max-height: 600px;
}
.post-cover img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ---------- Chia sẻ cuối bài ---------- */
.post-footer-share {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin: 8px 0 60px;
    padding: 18px 22px;
    border-radius: 14px;
    background: #fdf3f3;
    font-weight: 600;
    color: #1b1f23;
}

/* ---------- Khung chờ ---------- */
.sk {
    background: linear-gradient(90deg, #f1f1f1 25%, #e6e6e6 37%, #f1f1f1 63%);
    background-size: 400% 100%;
    animation: sk-shine 1.4s ease infinite;
    border-radius: 8px;
}
.sk-pill { width: 110px; height: 24px; margin-bottom: 16px; border-radius: 999px; }
.sk-title { height: 38px; margin-bottom: 12px; }
.sk-title.short { width: 60%; }
.sk-line { height: 18px; width: 80%; margin-top: 20px; }
@keyframes sk-shine {
    0% { background-position: 100% 50%; }
    100% { background-position: 0 50%; }
}

@media (max-width: 991px) {
    .post-hero {
        padding-top: 100px;
    }
    .post-title {
        font-size: 32px;
    }
}
@media (max-width: 600px) {
    .post-hero {
        padding: 90px 0 24px;
    }
    .post-title {
        font-size: 26px;
    }
    .post-lead {
        font-size: 16px;
    }
    .share-btn--text span {
        display: none;
    }
    .post-cover {
        margin-bottom: 28px;
        border-radius: 12px;
    }
}
</style>
