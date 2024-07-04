<template>
    <!-- Services Section Start -->
    <div id="rs-services" class="rs-services main-home gray-bg pb-120 md-pt-70 md-pb-80">
        <div class="container">
            <div class="sec-title text-center mb-60 md-mb-40">
                <h2 class="title title2 pb-13">
                    Một số hình ảnh của <span style="color: #B11B1C">SMARTEDU</span>
                </h2>
                <div class="heading-border-line"></div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-20">
                    <div class="services-item">
                        <div class="services-content">
                            <img src="@/assets/images/common/sub-banner.jpg" alt="banner">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-20">
                    <div class="services-item">
                        <div class="services-content">
                            <img src="@/assets/images/common/banner.jpg" alt="banner">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-20">
                    <div class="services-item">
                        <div class="services-content">
                            <img src="@/assets/images/common/banner.jpg" alt="banner">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-20">
                    <div class="services-item">
                        <div class="services-content">
                            <img src="@/assets/images/common/sub-banner.jpg" alt="banner">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-20">
                    <div class="services-item">
                        <div class="services-content">
                            <img src="@/assets/images/common/sub-banner.jpg" alt="banner">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-20">
                    <div class="services-item">
                        <div class="services-content">
                            <img src="@/assets/images/common/sub-banner.jpg" alt="banner">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Services Section End -->
</template>

<script>
export default {
    name: "SubBanner"
}
</script>

<style scoped>
.services-item, .services-content{
    padding: 0 !important;
    overflow: hidden;
    height: 200px;
}
.services-item:hover > .services-content img{
    transform: scale(1.5);
}
.services-item:hover {
    background: white !important;
}
.services-content img{
    width: 100%;
    object-fit:cover;
    padding: 0 !important;
    transition: transform 0.5s ease-in-out;
}

</style>
