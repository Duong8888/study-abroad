<template>
    <!-- Banner Section Start -->
    <div class=" style5 h-50">
        <div class="pt-100">
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item" data-bs-interval="10000">
                        <img class="w-100" src="@/assets/images/common/banner.jpg" alt="logo">
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <img class="w-100" src="@/assets/images/common/banner-2.jpg" alt="logo">
                    </div>
                    <div class="carousel-item active">
                        <img class="w-100" src="@/assets/images/common/banner-3.jpg" alt="logo">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev" fdprocessedid="bo6mnr">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next" fdprocessedid="vceocj">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
            <FormRequest></FormRequest>
        </div>
    </div>
    <!-- Banner Section End -->

</template>

<script>
import FormRequest from "./FormRequest.vue"
export default {
    name: "Banner",
    components:{
        FormRequest
    }
}
</script>

<style scoped>
.carousel-control-prev, .carousel-control-next{
    background: rgb(255, 255, 255,0);
    border: none;
    height: 400px;
}
.carousel-item{
    height: 450px;
}

</style>
