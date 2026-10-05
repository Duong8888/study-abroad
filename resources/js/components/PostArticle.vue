<template>
    <div class="post-article" :class="{ 'has-sidebar': showSidebar }">
        <div class="post-article__main">
            <!-- Mục lục dạng hộp (mobile, hoặc khi không có sidebar) -->
            <nav v-if="toc.length" class="toc-box" :class="{ 'd-lg-none': showSidebar }" aria-label="Mục lục">
                <button type="button" class="toc-box__header" @click="boxOpen = !boxOpen" :aria-expanded="boxOpen">
                    <span>Nội dung chính <small class="toc-count">({{ toc.length }} mục)</small></span>
                    <svg class="toc-chevron" :class="{ open: boxOpen }" xmlns="http://www.w3.org/2000/svg" width="22"
                         height="22" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path>
                    </svg>
                </button>
                <ol v-show="boxOpen" class="toc-list">
                    <li v-for="item in toc" :key="item.id" :class="`depth-${item.depth}`">
                        <a :href="`#${item.id}`" :class="{ active: item.id === activeId }"
                           @click.prevent="goTo(item.id)">
                            <span v-if="item.number" class="toc-number">{{ item.number }}</span>{{ item.text }}
                        </a>
                    </li>
                </ol>
            </nav>

            <div v-if="universityInfo" class="mt-4 mb-2 university-info" v-html="universityInfo"></div>
            <div ref="content" class="post-content mb-5" v-html="content"></div>
        </div>

        <!-- Mục lục dạng sidebar dính (desktop) -->
        <aside v-if="showSidebar" class="post-article__aside d-none d-lg-block">
            <nav class="toc-sidebar" aria-label="Mục lục">
                <div class="toc-sidebar__title">Nội dung chính</div>
                <div class="toc-progress"><div class="toc-progress__bar" :style="{ width: progress + '%' }"></div></div>
                <ol ref="sidebarList" class="toc-list">
                    <li v-for="item in toc" :key="item.id" :class="`depth-${item.depth}`">
                        <a :href="`#${item.id}`" :data-id="item.id" :class="{ active: item.id === activeId }"
                           @click.prevent="goTo(item.id)">
                            <span v-if="item.number" class="toc-number">{{ item.number }}</span>{{ item.text }}
                        </a>
                    </li>
                </ol>
            </nav>
        </aside>
    </div>
</template>

<script>
import {slugify} from '@/utils/slugify.js';
import '../../css/post-content.css';

// Khoảng cách chừa cho header dính khi cuộn tới một mục
const SCROLL_OFFSET = 110;
// Tiêu đề đã tự đánh số sẵn: "I.", "1.", "1.2", "a)"...
const NUMBERED_RE = /^\s*(?:[IVXLC]+|\d+(?:\.\d+)*|[a-z])\s*[.):-]?\s+/i;

export default {
    name: "PostArticle",
    props: {
        content: {type: String, default: ''},
        universityInfo: {type: String, default: ''},
        // compact: luôn dùng mục lục dạng hộp, không đổi URL (dùng cho xem trước trong admin)
        compact: {type: Boolean, default: false},
    },
    data() {
        return {
            toc: [],
            activeId: null,
            boxOpen: true,
            progress: 0,
            ticking: false,
        };
    },
    computed: {
        showSidebar() {
            return !this.compact && this.toc.length > 0;
        },
    },
    watch: {
        content: {
            handler() {
                this.$nextTick(() => {
                    this.cleanContent();
                    this.buildToc();
                    this.wrapWideTables();
                    this.scrollToHash();
                });
            },
            immediate: true,
        },
    },
    mounted() {
        // capture = true để bắt cả sự kiện cuộn bên trong modal xem trước
        document.addEventListener('scroll', this.onScroll, true);
        window.addEventListener('resize', this.onScroll);
        // Tính lại mục đang đọc khi nội dung đổi kích thước hoặc vừa được hiện ra (vd. modal xem trước)
        if (window.ResizeObserver && this.$refs.content) {
            this.resizeObserver = new ResizeObserver(() => this.onScroll());
            this.resizeObserver.observe(this.$refs.content);
        }
    },
    beforeUnmount() {
        document.removeEventListener('scroll', this.onScroll, true);
        window.removeEventListener('resize', this.onScroll);
        this.resizeObserver?.disconnect();
    },
    methods: {
        headingElements() {
            const root = this.$refs.content;
            return root ? Array.from(root.querySelectorAll('h1, h2, h3, h4')) : [];
        },
        buildToc() {
            const headings = this.headingElements().filter(h => h.textContent.trim());
            const usedIds = new Set();
            const levels = headings.map(h => Number(h.tagName[1]));
            const minLevel = levels.length ? Math.min(...levels) : 1;

            // Nếu phần lớn tiêu đề đã tự đánh số thì không đánh số thêm
            const numberedCount = headings.filter(h => NUMBERED_RE.test(h.textContent)).length;
            const autoNumber = numberedCount < headings.length / 2;
            const counters = [0, 0, 0, 0];

            this.toc = headings.map((heading, index) => {
                const text = heading.textContent.replace(/\s+/g, ' ').trim();
                const depth = Math.min(levels[index] - minLevel, 3);

                let base = heading.id || slugify(text) || `muc-${index + 1}`;
                let id = base;
                for (let n = 2; usedIds.has(id); n++) {
                    id = `${base}-${n}`;
                }
                usedIds.add(id);
                heading.id = id;

                counters[depth]++;
                counters.fill(0, depth + 1);
                const number = autoNumber
                    ? counters.slice(0, depth + 1).map(c => c || 1).join('.') + '.'
                    : '';

                return {id, text, depth, number};
            });
            this.activeId = this.toc.length ? this.toc[0].id : null;
            this.onScroll();
        },
        // Dọn nội dung dán từ Word/Docs: bỏ đoạn trống, cho ảnh tải lười
        cleanContent() {
            const root = this.$refs.content;
            if (!root) return;
            root.querySelectorAll('p, div:not([class])').forEach(el => {
                const empty = !el.textContent.replace(/[\s\p{Cf}]/gu, '')
                    && !el.querySelector('img, iframe, video, table, hr, input, a');
                if (empty) el.remove();
            });
            root.querySelectorAll('img').forEach(img => {
                img.loading = 'lazy';
                img.decoding = 'async';
            });
            root.querySelectorAll('a[href^="http"]').forEach(a => {
                if (a.hostname !== window.location.hostname) {
                    a.target = '_blank';
                    a.rel = 'noopener';
                }
            });
        },
        wrapWideTables() {
            const root = this.$refs.content;
            if (!root) return;
            root.querySelectorAll('table').forEach(table => {
                if (table.parentElement.classList.contains('table-scroll')) return;
                const wrapper = document.createElement('div');
                wrapper.className = 'table-scroll';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            });
        },
        onScroll() {
            if (this.ticking) return;
            this.ticking = true;
            requestAnimationFrame(() => {
                this.ticking = false;
                this.updateActive();
            });
        },
        updateActive() {
            const headings = this.toc.map(item => document.getElementById(item.id)).filter(Boolean);
            // Nội dung đang bị ẩn (chưa hiển thị) thì chưa tính được vị trí
            if (!headings.length || !this.$refs.content.offsetHeight) return;

            let current = headings[0].id;
            for (const heading of headings) {
                if (heading.getBoundingClientRect().top - SCROLL_OFFSET <= 5) {
                    current = heading.id;
                } else {
                    break;
                }
            }
            if (current !== this.activeId) {
                this.activeId = current;
                this.$nextTick(this.keepActiveVisible);
            }

            const rect = this.$refs.content.getBoundingClientRect();
            const total = rect.height - window.innerHeight + SCROLL_OFFSET;
            const passed = SCROLL_OFFSET - rect.top;
            this.progress = Math.max(0, Math.min(100, total > 0 ? (passed / total) * 100 : 100));
        },
        keepActiveVisible() {
            // Giữ mục đang đọc luôn hiện trong sidebar khi mục lục dài
            const list = this.$refs.sidebarList;
            if (!list) return;
            const link = list.querySelector(`a[data-id="${CSS.escape(this.activeId)}"]`);
            const box = list.closest('.toc-sidebar');
            if (!link || !box) return;
            const linkTop = link.offsetTop - box.offsetTop;
            if (linkTop < box.scrollTop || linkTop > box.scrollTop + box.clientHeight - 40) {
                box.scrollTo({top: linkTop - box.clientHeight / 3, behavior: 'smooth'});
            }
        },
        goTo(id) {
            const target = document.getElementById(id);
            if (!target) return;
            target.scrollIntoView({behavior: 'smooth', block: 'start'});
            this.activeId = id;
            if (!this.compact) {
                history.replaceState(history.state, '', `#${id}`);
            }
        },
        scrollToHash() {
            if (this.compact || !window.location.hash) return;
            const id = decodeURIComponent(window.location.hash.slice(1));
            if (this.toc.some(item => item.id === id)) {
                setTimeout(() => this.goTo(id), 300);
            }
        },
    },
}
</script>

<style scoped>
.post-article {
    --toc-color: #b21818;
}
.post-article.has-sidebar {
    display: grid;
    grid-template-columns: minmax(0, 1fr);
    gap: 40px;
}
@media (min-width: 992px) {
    .post-article.has-sidebar {
        grid-template-columns: minmax(0, 1fr) 280px;
    }
}
.post-article__main {
    min-width: 0;
}

/* ---------- Mục lục chung ---------- */
.toc-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.toc-list li {
    margin: 0;
}
.toc-list a {
    display: flex;
    gap: 6px;
    padding: 6px 10px;
    border-left: 2px solid transparent;
    color: #444;
    line-height: 1.4;
    text-decoration: none;
    transition: color .15s, background-color .15s, border-color .15s;
}
.toc-list a:hover {
    color: var(--toc-color);
    background: rgba(178, 24, 24, .05);
}
.toc-list a.active {
    color: var(--toc-color);
    border-left-color: var(--toc-color);
    background: rgba(178, 24, 24, .08);
    font-weight: 600;
}
.toc-list .depth-0 > a { font-weight: 600; }
.toc-list .depth-0 > a.active { font-weight: 700; }
.toc-list .depth-1 > a { padding-left: 24px; font-size: 15px; }
.toc-list .depth-2 > a { padding-left: 38px; font-size: 14px; }
.toc-list .depth-3 > a { padding-left: 52px; font-size: 14px; }
.toc-number {
    flex-shrink: 0;
    color: var(--toc-color);
}

/* ---------- Mục lục dạng hộp ---------- */
.toc-box {
    margin-top: 20px;
    margin-bottom: 24px;
    border: 1px solid rgba(178, 24, 24, .35);
    border-radius: 10px;
    background: #fdf8f8;
    overflow: hidden;
}
.toc-box__header {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border: 0;
    background: transparent;
    color: var(--toc-color);
    font-size: 20px;
    font-weight: 700;
    text-align: left;
    cursor: pointer;
}
.toc-count {
    font-size: 14px;
    font-weight: 400;
    color: #777;
}
.toc-chevron {
    transition: transform .2s;
}
.toc-chevron.open {
    transform: rotate(180deg);
}
.toc-box .toc-list {
    padding: 4px 8px 12px;
    border-top: 1px solid rgba(178, 24, 24, .2);
}

/* ---------- Mục lục dạng sidebar ---------- */
.post-article__aside {
    position: relative;
}
.toc-sidebar {
    position: sticky;
    top: 100px;
    max-height: calc(100vh - 120px);
    overflow-y: auto;
    padding: 16px 8px 16px 0;
    scrollbar-width: thin;
}
.toc-sidebar__title {
    padding-left: 10px;
    margin-bottom: 8px;
    color: var(--toc-color);
    font-size: 18px;
    font-weight: 700;
}
.toc-progress {
    height: 3px;
    margin: 0 0 10px 10px;
    border-radius: 3px;
    background: #eee;
    overflow: hidden;
}
.toc-progress__bar {
    height: 100%;
    background: var(--toc-color);
    transition: width .1s linear;
}
.toc-sidebar .toc-list {
    border-left: 1px solid #eee;
}
.toc-sidebar .toc-list a {
    margin-left: -1px;
    font-size: 14px;
}

.university-info {
    margin-bottom: 24px;
}
.university-info :deep(p) {
    margin: 0 !important;
}
</style>
