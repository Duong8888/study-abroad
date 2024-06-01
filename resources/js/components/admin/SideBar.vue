<template>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <router-link :to="{name:'Home'}">
            <span class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon rotate-n-15">
<!--                    <i class="fas fa-laugh-wink"></i>-->
                    <img class="normal-logo" src="@/assets/images/common/logo-white.png" alt="logo">
                </div>
                <div class="sidebar-brand-text mx-3">SMART EDU</div>
            </span>
        </router-link>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <!--        <li class="nav-item">-->
        <!--            <a class="nav-link" href="index.html">-->
        <!--                <i class="fas fa-fw fa-tachometer-alt"></i>-->
        <!--                <span>Dashboard</span></a>-->
        <!--        </li>-->

        <!-- Divider -->
        <!--        <hr class="sidebar-divider">-->

        <!-- Heading -->
        <!--        s-->

        <!-- Nav Item - Pages Collapse Menu -->
        <!--        <li class="nav-item">-->
        <!--            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"-->
        <!--               aria-expanded="true" aria-controls="collapseTwo">-->
        <!--                <i class="fas fa-fw fa-cog"></i>-->
        <!--                <span>Components</span>-->
        <!--            </a>-->
        <!--            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">-->
        <!--                <div class="bg-white py-2 collapse-inner rounded">-->
        <!--                    <h6 class="collapse-header">Custom Components:</h6>-->
        <!--                    <a class="collapse-item" href="buttons.html">Buttons</a>-->
        <!--                    <a class="collapse-item" href="cards.html">Cards</a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </li>-->

        <!-- Nav Item - Utilities Collapse Menu -->
        <!--        <li class="nav-item">-->
        <!--            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"-->
        <!--               aria-expanded="true" aria-controls="collapseUtilities">-->
        <!--                <i class="fas fa-fw fa-wrench"></i>-->
        <!--                <span>Utilities</span>-->
        <!--            </a>-->
        <!--            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"-->
        <!--                 data-parent="#accordionSidebar">-->
        <!--                <div class="bg-white py-2 collapse-inner rounded">-->
        <!--                    <h6 class="collapse-header">Custom Utilities:</h6>-->
        <!--                    <a class="collapse-item" href="utilities-color.html">Colors</a>-->
        <!--                    <a class="collapse-item" href="utilities-border.html">Borders</a>-->
        <!--                    <a class="collapse-item" href="utilities-animation.html">Animations</a>-->
        <!--                    <a class="collapse-item" href="utilities-other.html">Other</a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </li>-->

        <!-- Divider -->
        <!--        <hr class="sidebar-divider">-->

        <!-- Heading -->
        <!--        <div class="sidebar-heading">-->
        <!--            Addons-->
        <!--        </div>-->

        <!-- Nav Item - Pages Collapse Menu -->
        <!--        <li class="nav-item">-->
        <!--            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"-->
        <!--               aria-expanded="true" aria-controls="collapsePages">-->
        <!--                <i class="fas fa-fw fa-folder"></i>-->
        <!--                <span>Pages</span>-->
        <!--            </a>-->
        <!--            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">-->
        <!--                <div class="bg-white py-2 collapse-inner rounded">-->
        <!--                    <h6 class="collapse-header">Login Screens:</h6>-->
        <!--                    <a class="collapse-item" href="login.html">Login</a>-->
        <!--                    <a class="collapse-item" href="register.html">Register</a>-->
        <!--                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>-->
        <!--                    <div class="collapse-divider"></div>-->
        <!--                    <h6 class="collapse-header">Other Pages:</h6>-->
        <!--                    <a class="collapse-item" href="404.html">404 Page</a>-->
        <!--                    <a class="collapse-item" href="blank.html">Blank Page</a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </li>-->

        <!-- Nav Item - Charts -->
        <li class="nav-item" :class="{ active: $route.name === 'Posts' }">
            <router-link :to="{name:'Posts'}">
                <span class="nav-link">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Bài viết</span></span>
            </router-link>

        </li>


        <!-- Nav Item - Tables -->
        <li class="nav-item" :class="{ active: $route.name === 'Request' }">
            <router-link :to="{name:'Request'}">
                <span class="nav-link">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Yêu cầu tư vấn</span></span>
            </router-link>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item" :class="{ active: $route.name === 'Category' }">
            <router-link :to="{name:'Category'}">
                <span class="nav-link">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Danh mục</span></span>
            </router-link>

        </li>

        <li class="nav-item" :class="{ active: $route.name === 'University' }">
            <router-link :to="{name:'University'}">
                <span class="nav-link">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Các trường liên kết</span></span>
            </router-link>
        </li>

        <li class="nav-item" :class="{ active: $route.name === 'Team' }">
            <router-link :to="{name:'Team'}">
                <span class="nav-link">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Đội ngũ</span></span>
            </router-link>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <div class="sidebar-heading">
            Setings
        </div>

        <li class="nav-item" :class="{ active: $route.name === 'Menu' }">
            <router-link :to="{name:'Menu'}">
                <span class="nav-link">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Menu</span></span>
            </router-link>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" @click="status = !status" data-toggle="collapse"
               data-target="#collapsePages"
               aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Banners</span>
            </a>
            <div id="collapsePages" v-if="status" class="collapse" aria-labelledby="headingPages"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link :to="{name:'TopBanner'}">
                        <a class="collapse-item" :class="{ active: $route.name === 'TopBanner' }" href="#">Top
                            banner</a>
                    </router-link>
                    <router-link :to="{name:'AdsBanner'}">
                        <a class="collapse-item" :class="{ active: $route.name === 'AdsBanner' }" href="#">Ads
                            banner</a>
                    </router-link>
                </div>
            </div>
        </li>

        <li class="nav-item" @click="logoutBtn">
            <router-link :to="{name:'Login'}">
                <span class="nav-link">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    <span>Logout</span>
                </span>
            </router-link>
        </li>


        <!-- Sidebar Toggler (Sidebar) -->
        <!--        <div class="text-center d-none d-md-inline">-->
        <!--            <button class="rounded-circle border-0" id="sidebarToggle"></button>-->
        <!--        </div>-->

    </ul>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "SideBar",
    data() {
        return {
            status: true,
        }
    },
    methods: {
        ...mapActions('auth', ['logout']),
        logoutBtn() {
            this.logout();
        }
    },
}
</script>

<style scoped>
.normal-logo {
    width: 30px;
    height: 30px;
}

.bg-gradient-primary {
    background: #be1510 !important;
}

</style>
