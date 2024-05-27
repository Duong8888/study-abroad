<template>
    <div class="container">
        <TablePosts :data="postsAll" @delete="postsDelete"></TablePosts>
    </div>
</template>

<script>

import TablePosts from '../../components/admin/TablePosts.vue'
import {mapActions, mapGetters} from 'vuex';

export default {
    name: "Posts",
    components: {
        TablePosts,
    },
    computed: {
        ...mapGetters('posts', ['postsAll']),
    },
    methods: {
        ...mapActions('posts', ['fetchPost','deletePosts']),
        async postsDelete(data){
            await this.deletePosts(data);
            await this.fetchPost();
        }
    },
    created() {
        this.fetchPost();
    },
}
</script>

<style scoped>
.custom-img {
    width: 100%;
    height: 200px;
}

.box-img img {
    width: 100%;
    height: 100%;
    object-fit: contain !important;
}

.box-img {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;
    border: 4px dashed #cccc;
    border-radius: 10px;
}
</style>
