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
    <Introduce></Introduce>
    <Team></Team>
    <Universities></Universities>
    <Posts></Posts>
    <FormRequest></FormRequest>
    <Footer></Footer>
</template>

<script>
import Footer from '@/components/Footer.vue';
import Header from '@/components/Header.vue';
import Banner from '@/components/Banner.vue';
import Team from '@/components/Team.vue';
import Posts from '@/components/Posts.vue';
import Introduce from '@/components/Introduce.vue';
import Universities from '@/components/Universities.vue';
import FormRequest from '@/components/FormRequestFull.vue';

export default {
    name: "Home",
    components: {
        Header,
        Banner,
        Footer,
        Posts,
        FormRequest,
        Universities,
        Team,
        Introduce
    }
}
</script>
