<template>
    <!-- Partner Start -->
    <div class="rs-partner main-home gray-bg2 pb-80 md-pt-70 md-pb-80">
        <div class="container">
            <div class="sec-title text-center mb-60" v-if="showTitle">
                <h2 class="title title2 pb-13">
                    Các trường đại học <span style="color: #ed1e24">SMART EDU</span> liên kết
                </h2>
                <div class="heading-border-line"></div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-3 col-md-6 col-sm-6 col-6" v-for="item in items" :key="item">
                    <div class="grid-figure">
                        <div class="log-img">
                            <a href="#"><img :src="item.logo" :alt="item.university_name"></a>
                        </div>
                    </div>
                </div>
<!--                <div class="col-lg-3 col-md-6 col-sm-6 col-6">-->
<!--                    <div class="grid-figure">-->
<!--                        <div class="log-img">-->
<!--                            <a href="https://rstheme.com/"><img src="@/assets/images/partner/main-home/2.png" alt="images"></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-lg-3 col-md-6 col-sm-6 col-6">-->
<!--                    <div class="grid-figure">-->
<!--                        <div class="log-img">-->
<!--                            <a href="https://rstheme.com/"><img src="@/assets/images/partner/main-home/3.png" alt="images"></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-lg-3 col-md-6 col-sm-6 col-6">-->
<!--                    <div class="grid-figure border-no">-->
<!--                        <div class="log-img">-->
<!--                            <a href="https://rstheme.com/"><img src="@/assets/images/partner/main-home/4.png" alt="images"></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-lg-3 col-md-6 col-sm-6 col-6">-->
<!--                    <div class="grid-figure bottom-noborder">-->
<!--                        <div class="log-img">-->
<!--                            <a href="https://rstheme.com/"><img src="@/assets/images/partner/main-home/5.png" alt="images"></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-lg-3 col-md-6 col-sm-6 col-6">-->
<!--                    <div class="grid-figure bottom-noborder">-->
<!--                        <div class="log-img">-->
<!--                            <a href="https://rstheme.com/"><img src="@/assets/images/partner/main-home/6.png" alt="images"></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-lg-3 col-md-6 col-sm-6 col-6">-->
<!--                    <div class="grid-figure bottom-noborder">-->
<!--                        <div class="log-img">-->
<!--                            <a href="https://rstheme.com/"><img src="@/assets/images/partner/main-home/7.png" alt="images"></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-lg-3 col-md-6 col-sm-6 col-6">-->
<!--                    <div class="grid-figure border-no bottom-noborder">-->
<!--                        <div class="log-img">-->
<!--                            <a href="https://rstheme.com/"><img src="@/assets/images/partner/main-home/8.png" alt="images"></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
    <!-- Partner End -->
</template>

<script>
export default {
    name: "Universities",
    props:{
        showTitle:{
            type: Boolean,
            default: true
        },
        items:{
            type: Array,
            default: [],
        },
    }
}
</script>

<style scoped>

</style>
