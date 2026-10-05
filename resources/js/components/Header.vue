<template>
    <!--Full width header Start-->
    <div class="full-width-header gray-bg2">
        <!--Header Start-->
        <header id="rs-header" class="rs-header style1 modify1 header-transparent">
            <!-- Menu Start -->
            <div class="menu-area menu-sticky bg-new">
                <div class="container-fluid bg-new">
                    <div class="row custom-row">
                        <div class="col-cell">
                            <div class="logo-area">
                                <a href="/">
                                    <img class="normal-logo" :src="logoWhite" alt="logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-cell">
                            <div class="rs-menu-area">
                                <div class="main-menu">
                                    <div class="mobile-menu" @click="openMobileMenu">
                                        <a class="rs-menu-toggle" id="nav-expander2">
                                            <span class="dot1 nav-dots"></span>
                                            <span class="dot2 nav-dots"></span>
                                            <span class="dot3 nav-dots"></span>
                                            <span class="dot4 nav-dots"></span>
                                        </a>
                                    </div>
                                    <nav class="rs-menu hidden-md">
                                        <ul class="nav-menu">
                                            <li v-for="menu in menuTree" :key="menu.id"
                                                :class="{ 'active-menu': isActiveMenu(menu) }">
                                                <a style="font-weight: 900" class="mx-3 uppercase d-inline parent-menu"
                                                   :href="menu.children.length ? '#' : menu.url"
                                                   @click="menu.children.length && $event.preventDefault()">
                                                    {{ menu.title }}
                                                    <svg v-if="menu.children.length"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path
                                                            d="M11.178 19.569a.998.998 0 0 0 1.644 0l9-13A.999.999 0 0 0 21 5H3a1.002 1.002 0 0 0-.822 1.569l9 13z"></path>
                                                    </svg>
                                                </a>
                                                <ul v-if="menu.children.length" class="sub-menu">
                                                    <li v-for="child in menu.children" :key="child.id"
                                                        :class="{ 'active-menu': isActiveMenu(child), 'has-grandchild': child.children.length }">
                                                        <a :href="child.children.length ? '#' : child.url" class="child-menu"
                                                           @click="child.children.length && $event.preventDefault()">
                                                            {{ child.title }}
                                                            <span v-if="child.children.length" class="child-menu__arrow">›</span>
                                                        </a>
                                                        <!-- Menu cấp 3: bung sang phải -->
                                                        <ul v-if="child.children.length" class="sub-menu">
                                                            <li v-for="grandchild in child.children" :key="grandchild.id"
                                                                :class="{ 'active-menu': isActiveMenu(grandchild) }">
                                                                <a :href="grandchild.url" class="child-menu">{{ grandchild.title }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul> <!-- //.nav-menu -->
                                    </nav>
                                </div> <!-- //.main-menu -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Menu End -->

            <!-- Canvas Menu start -->
            <nav class="right_menu_togle hidden-md">
                <div class="close-btn">
                    <a id="nav-close" class="nav-close" @click="closeMobileMenu">
                        <div class="line">
                            <span class="line1"></span>
                            <span class="line2"></span>
                        </div>
                    </a>
                </div>
                <div class="canvas-logo">
                    <a href="/"><img :src="logoMain" alt="logo"></a>
                </div>
                <div class="offcanvas-text">
                    <p>Developing software applications and mobile apps for clients all over the world. From its
                        medieval origins.</p>
                </div>
                <div class="rs-gallery">
                    <div class="gallery-item">
                        <img src="@/assets/images/gallery/1.jpg" alt="images">
                    </div>
                    <div class="gallery-item">
                        <img src="@/assets/images/gallery/2.jpg" alt="images">
                    </div>
                    <div class="gallery-item">
                        <img src="@/assets/images/gallery/3.jpg" alt="images">
                    </div>
                    <div class="gallery-item">
                        <img src="@/assets/images/gallery/4.jpg" alt="images">
                    </div>
                </div>
                <div class="canvas-contact">
                    <div class="address-area">
                        <div class="address-list">
                            <div class="info-icon">
                                <i class="flaticon-location"></i>
                            </div>
                            <div class="info-content">
                                <h4 class="title">Address</h4>
                                <em>05 kandi BR. New York</em>
                            </div>
                        </div>
                        <div class="address-list">
                            <div class="info-icon">
                                <i class="flaticon-email"></i>
                            </div>
                            <div class="info-content">
                                <h4 class="title">Email</h4>
                                <em><a href="mailto:support@rstheme.com">support@rstheme.com</a></em>
                            </div>
                        </div>
                        <div class="address-list">
                            <div class="info-icon">
                                <i class="flaticon-call"></i>
                            </div>
                            <div class="info-content">
                                <h4 class="title">Phone</h4>
                                <em>+019988772</em>
                            </div>
                        </div>
                    </div>
                    <ul class="social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </nav>
            <!-- Canvas Menu end -->

            <!-- Canvas Menu start -->
            <nav class="right_menu_togle mobile-navbar-menu" id="mobile-navbar-menu">
                <div class="close-btn">
                    <a id="nav-close2" class="nav-close" @click="closeMobileMenu">
                        <div class="line">
                            <span class="line1"></span>
                            <span class="line2"></span>
                        </div>
                    </a>
                </div>
                <ul class="nav-menu">
                    <li v-for="menu in menuTree" :key="menu.id"
                        :class="{ 'menu-item-has-children has-sub': menu.children.length }">
                        <a :href="menu.children.length ? '#' : menu.url"
                           @click="menu.children.length && toggleSubmenu($event)">{{ menu.title }}</a>
                        <span v-if="menu.children.length" @click="toggleSubmenu" class="submenu-button"></span>
                        <ul v-if="menu.children.length" class="sub-menu">
                            <li v-for="child in menu.children" :key="child.id"
                                :class="{ 'menu-item-has-children has-sub': child.children.length }">
                                <a :href="child.children.length ? '#' : child.url"
                                   @click="child.children.length && toggleSubmenu($event)">{{ child.title }}</a>
                                <span v-if="child.children.length" @click="toggleSubmenu" class="submenu-button"></span>
                                <ul v-if="child.children.length" class="sub-menu">
                                    <li v-for="grandchild in child.children" :key="grandchild.id">
                                        <a :href="grandchild.url">{{ grandchild.title }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul> <!-- //.nav-menu -->
            </nav>
            <!-- Canvas Menu end -->
        </header>
        <!--Header End-->
    </div>
    <!--Full width header End-->

</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'Header',
    data() {
        return {
            action: true,
            menuItems: [],
        }
    },
    mounted() {
        this.handleScroll();
        window.addEventListener('scroll', this.handleScroll);
    },
    beforeDestroy() {
        window.removeEventListener('scroll', this.handleScroll);
    },
    computed: {
        ...mapGetters('menu', ['menuAll']),
        ...mapGetters('settings', ['logoMain', 'logoWhite']),
        // Cây menu tối đa 3 cấp: chỉ lấy mục đang bật, sắp xếp theo "order" rồi theo id
        menuTree() {
            const active = this.menuItems.filter(item => item.is_active === null || item.is_active === undefined || !!Number(item.is_active));
            const sorted = [...active].sort((a, b) => (a.order ?? 9999) - (b.order ?? 9999) || a.id - b.id);
            const build = (parentId, depth) => sorted
                .filter(item => (item.parent_id ?? null) == parentId)
                .map(item => ({...item, children: depth < 3 ? build(item.id, depth + 1) : []}));
            return build(null, 1);
        },
        currentPath() {
            return this.$route.path;
        },
        isActiveMenu() {
            const matches = (item) => {
                if (!item.url || item.url === '#') return false;
                const path = item.url.replace(/^https?:\/\/[^/]+/, '').split(/[?#]/)[0] || '/';
                const normalize = value => value.replace(/\/+$/, '') || '/';
                return normalize(path) === normalize(this.currentPath);
            };
            const check = (item) => matches(item) || (item.children || []).some(check);
            return check;
        }
    },
    watch: {
        menuAll: function (newValue) {
            if (newValue.length > 0) {
                this.menuItems = newValue;
            }
        },
    },
    created() {
        this.fetchMenu();
        this.loadSettings();
    },
    methods: {
        ...mapActions('menu', ['fetchMenu']),
        ...mapActions('settings', ['loadSettings']),
        // Mở/đóng menu con trên điện thoại (chỉ menu con trực tiếp của mục được bấm)
        toggleSubmenu(event) {
            event.preventDefault();
            const subMenu = event.target.closest('li').querySelector(':scope > .sub-menu');
            if (subMenu) subMenu.style.display = (subMenu.style.display == 'block') ? 'none' : 'block';
        },
        // Mở/đóng menu điện thoại. Dùng add/remove (không toggle) để không xung đột
        // với đoạn toggle sẵn có của theme trong public/assets/js/main.js
        openMobileMenu() {
            document.body.classList.add('nav-expanded');
        },
        closeMobileMenu() {
            document.body.classList.remove('nav-expanded');
        },
        handleScroll() {
            // const header = document.querySelector('.menu-sticky');
            // const sections = document.querySelectorAll('section');
            // const headerHeight = document.querySelector('#rs-header').offsetHeight;
            // const scrollTop = window.scrollY || document.documentElement.scrollTop;
            //
            // if (scrollTop < 1) {
            //     header.classList.remove('sticky');
            // } else {
            //     header.classList.add('sticky');
            // }
            //
            // sections.forEach(section => {
            //     const elementTop = section.offsetTop - headerHeight;
            //     if (scrollTop >= elementTop) {
            //         section.classList.add('loaded');
            //     }
            // });
        }
    }
}
</script>

<style scoped>
.normal-logo{
    transform: scale(1.3);
    width: 60px;
    max-height: 100px !important;
}
.nav-menu > li svg{
    color: #FFFFFF !important;
    fill: #FFFFFF !important;
}
.parent-menu{
    color: #FFFFFF !important;
    fill: #FFFFFF !important;
}

.nav-menu > li:hover > .parent-menu{
    border-bottom: 5px solid #FFFFFF;
}

.sub-menu{
    padding: 0px !important;
}
.has-grandchild {
    position: relative;
}
/* Giữ đúng chữ hoa/thường như khi nhập trong admin (theme mặc định viết hoa mỗi từ) */
.nav-menu .sub-menu a {
    text-transform: none !important;
}
.has-grandchild > a {
    display: flex !important;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.child-menu__arrow {
    font-size: 20px;
    line-height: 1;
}
/* Menu con giãn theo độ dài chữ (theme cố định 260px làm chữ bị xuống dòng) */
.rs-menu .nav-menu .sub-menu a {
    width: auto !important;
    min-width: 260px;
    white-space: nowrap;
}
/* Menu cấp 3 bung sang phải, ngang hàng với mục cha (chỉ menu desktop) */
.rs-menu .nav-menu .sub-menu .sub-menu {
    top: 0 !important;
    left: 100% !important;
}
.sub-menu > li > a{
    border-bottom: 1px solid #f2f2f2;
}
.sub-menu > li:hover > a{
    color: #be1510 !important;
}

.active-menu > .parent-menu{
    border-bottom: 5px solid #FFFFFF;
    color: #FFFFFF !important;
}
.active-menu > .parent-menu svg{
    fill: #FFFF !important;
}

.bg-new {
    background: #B21818 !important;
}
.active-menu > .child-menu, .child-menu svg{
    color: #be1510 !important;
    fill: #be1510 !important;
}
@media only screen and (max-width: 990px) {
    .container-fluid {
        padding-left: 30px;
        padding-right: 30px;
        position: fixed;
        background: white;
    }
    .normal-logo{
        width: 35px;
        transform: scale(1.2);
        max-height: 100px !important;
    }
}
</style>
