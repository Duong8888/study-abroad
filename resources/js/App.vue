<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>

export default {
    name: "App",
    components: {}
}
</script>

<style>
    body {
        font-family: 'Roboto', sans-serif !important;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Montserrat', sans-serif !important;
        transform: scaleY(1.14);
    }

    p, a , div{
        font-family: 'Open Sans', sans-serif !important;
    }
</style>
