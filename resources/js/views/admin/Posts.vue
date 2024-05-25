<template>
    <div id="wrapper">
        <SideBar></SideBar>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <TopBar></TopBar>
                <ul>
                    <li v-for="book in books" :key="book.id">{{ book.title }}</li>
                </ul>
                <PostsList></PostsList>
            </div>
            <Footer></Footer>
        </div>
    </div>
</template>

<script>
import SideBar from '../../components/admin/SideBar.vue'
import TopBar from "../../components/admin/TopBar.vue";
import PostsList from '../../components/admin/Posts.vue'
import Footer from "../../components/admin/Footer.vue";
export default {
    name: "Posts",
    components: {
        SideBar,
        TopBar,
        PostsList,
        Footer
    },
    computed: {

    },
    methods: {

    }
}
</script>

<style scoped>

</style>
