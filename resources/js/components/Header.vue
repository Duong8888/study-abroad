<template>
    <!--Full width header Start-->
    <div class="full-width-header gray-bg2">
        <!--Header Start-->
        <header id="rs-header" class="rs-header style1 modify1 header-transparent">
            <!-- Menu Start -->
            <div class="menu-area menu-sticky">
                <div class="container-fluid">
                    <div class="row custom-row">
                        <div class="col-cell">
                            <div class="logo-area">
                                <a href="/">
                                    <img class="normal-logo" src="@/assets/images/common/logo.png" alt="logo">
                                    <img class="sticky-logo" src="@/assets/images/common/logo.png" alt="logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-cell">
                            <div class="rs-menu-area">
                                <div class="main-menu">
                                    <div class="mobile-menu">
                                        <a class="rs-menu-toggle" id="nav-expander2">
                                            <span class="dot1 nav-dots"></span>
                                            <span class="dot2 nav-dots"></span>
                                            <span class="dot3 nav-dots"></span>
                                            <span class="dot4 nav-dots"></span>
                                        </a>
                                    </div>
                                    <nav class="rs-menu hidden-md">
                                        <ul class="nav-menu">
                                            <li v-for="menu in menuItems.filter(item => item.parent_id == null)" :class="{ 'active-menu': isActiveMenu(menu) }"
                                                :key="menu.id" >
                                                <a style="font-weight: 900" class="mx-3 uppercase d-inline parent-menu"
                                                   :href="(getChildItems(menu.id).length > 0) ? '#' : menu.url">
                                                    {{ menu.title }}
                                                    <svg v-if="getChildItems(menu.id).length > 0"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path
                                                            d="M11.178 19.569a.998.998 0 0 0 1.644 0l9-13A.999.999 0 0 0 21 5H3a1.002 1.002 0 0 0-.822 1.569l9 13z"></path>
                                                    </svg>
                                                </a>
                                                <ul class="sub-menu">
                                                    <!--                                                    class="menu-item-has-children current-menu-item"-->
                                                    <li v-for="child in getChildItems(menu.id)" :key="child"
                                                        :class="{ 'active-menu': isActiveMenu(child) }">
                                                        <a :href="child.url" class="child-menu">{{ child.title }}</a>
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
                    <a id="nav-close" class="nav-close">
                        <div class="line">
                            <span class="line1"></span>
                            <span class="line2"></span>
                        </div>
                    </a>
                </div>
                <div class="canvas-logo">
                    <a href="index.html"><img src="@/assets/images/logo-dark.png" alt="logo"></a>
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
                    <a id="nav-close2" class="nav-close">
                        <div class="line">
                            <span class="line1"></span>
                            <span class="line2"></span>
                        </div>
                    </a>
                </div>
                <ul class="nav-menu">
                    <li class="menu-item-has-children has-sub"
                        v-for="menu in menuItems.filter(item => item.parent_id == null)" :key="menu">
                        <a :href="(getChildItems(menu.id).length > 0) ? '#' : menu.url">{{ menu.title }}</a>
                        <span v-if="(getChildItems(menu.id).length > 0)" @click="showItem"
                              class="submenu-button"></span>
                        <ul class="sub-menu">
                            <li v-for="child in getChildItems(menu.id)" :key="child"><a
                                :href="child.url">{{ child.title }}</a></li>
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
            menuItems: [
                {id: 1, title: 'Home', url: '/', parent_id: null},
            ],
            currentUrl: ''
        }
    },
    mounted() {
        this.handleScroll();
        window.addEventListener('scroll', this.handleScroll);
        this.showMenu();
        this.currentUrl = window.location.href;
        console.log(this.currentUrl);
    },
    beforeDestroy() {
        window.removeEventListener('scroll', this.handleScroll);
    },
    computed: {
        ...mapGetters('menu', ['menuAll']),
        activeParent() {
            return true;
        },
        isActiveMenu() {
            return menu => {
                if (menu.url == this.currentUrl) {
                    return true;
                }
                const children = this.menuItems.filter(item => item.parent_id == menu.id);
                if (children && children.length) {
                    return children.some(child => child.url == this.currentUrl);
                }
                return false;
            };
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
    },
    methods: {
        ...mapActions('menu', ['fetchMenu']),
        getChildItems(parentId) {
            return this.menuItems.filter(item => item.parent_id == parentId);
        },
        showItem() {
            const subMenu = event.target.closest('.menu-item-has-children').querySelector('.sub-menu');
            subMenu.style.display = (subMenu.style.display == 'block') ? 'none' : 'block';
        },
        showMenu() {
            $('.mobile-menu, .line').on('click', function () {
                const body = document.querySelector('body');
                if (this.action) {
                    body.classList.add('nav-expanded');
                } else {
                    body.classList.remove('nav-expanded');
                }
                this.action = !this.action;
            });
        },
        handleScroll() {
            const header = document.querySelector('.menu-sticky');
            const sections = document.querySelectorAll('section');
            const headerHeight = document.querySelector('#rs-header').offsetHeight;
            const scrollTop = window.scrollY || document.documentElement.scrollTop;

            if (scrollTop < 1) {
                header.classList.remove('sticky');
            } else {
                header.classList.add('sticky');
            }

            sections.forEach(section => {
                const elementTop = section.offsetTop - headerHeight;
                if (scrollTop >= elementTop) {
                    section.classList.add('loaded');
                }
            });
        }
    }
}
</script>

<style scoped>
.normal-logo, .sticky-logo {
    transform: scale(5);
}
.nav-menu > li a, .nav-menu > li svg{
    color: #666 !important;
    fill: #666 !important;
}

.nav-menu > li:hover > .parent-menu{
    color: #ed1e24 !important;
    border-bottom: 5px solid #ed1e24;
}
.nav-menu > li:hover > .parent-menu > svg{
    fill: #ed1e24 !important;
}
.active-menu > .parent-menu{
    border-bottom: 5px solid #ed1e24;
    color: #ed1e24 !important;
}
.active-menu > .parent-menu svg{
    fill: #ed1e24 !important;
}
.active-menu > .child-menu, .child-menu svg{
    color: #ed1e24 !important;
    fill: #ed1e24 !important;
}
</style>
