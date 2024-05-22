<template>
    <!-- Banner Section Start -->
    <div class="rs-banner style5 h-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 pr-90 md-pr-15">
                    <div class="banner-content">
                        <h4>Marketing Agency</h4>
                        <div class="description">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                sed do eiusmod tempor incididunt</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6"></div>
            </div>
            <FormRequest></FormRequest>
        </div>
        <div class="animate-part">
            <div class="spiner triangle">
                <img class="spine" src="@/assets/images/banner/style4/1.png" alt="images">
            </div>
            <div class="spiner dot-style">
                <img class="dance2" src="@/assets/images/banner/style4/2.png" alt="images">
            </div>
            <div class="spiner horizontal">
                <img class="scale horizontal" src="@/assets/images/banner/style4/3.png" alt="images">
            </div>
            <div class="spiner horizontal2">
                <img class="scale" src="@/assets/images/banner/style4/4.png" alt="images">
            </div>
            <div class="spiner dot-style2">
                <img class="dance2" src="@/assets/images/banner/style4/5.png" alt="images">
            </div>
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

</style>
