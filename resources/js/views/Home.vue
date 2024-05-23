<template>
    <div class="offwrap"></div>
    <!--Preloader area start here-->
    <div id="loader" class="loader">
        <div class="loader-container"></div>
    </div>
    <!--Preloader area End here-->
    <div class="main-content">
        <Header></Header>
    </div>
    <Banner></Banner>
    <Test></Test>
    <Footer></Footer>
</template>

<script>
import Footer from '@/components/Footer.vue';
import Header from '@/components/Header.vue';
import Banner from '@/components/Banner.vue';
import Test from '@/components/Test.vue';

export default {
    name: "Home",
    components: {
        Header,
        Banner,
        Footer,
        Test
    }
}
</script>
