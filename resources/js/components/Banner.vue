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
            <!-- Seo Website Section Start -->
            <div class="col-lg-8 rs-seo-website style1 bg25 pt-20 pb-30 md-pt-70 md-pb-80 border rounded mx-auto mb-200 box-request">
                <div class="container flex-column d-flex align-items-center">
                    <p class="text-white font-weight-bold fs-6">Đăng ký nhận tư vấn</p>
                    <form class="newsletter-form mx-0 row w-100">
                        <input type="email" id="email" name="email" placeholder="Họ và tên" required="">
                        <input type="text" id="website" name="website" placeholder="Số điện thoại" required="">
                        <button type="submit" class="rounded relative h-100">Đăng ký</button>
                    </form>
                </div>
            </div>
            <!-- Seo Website Section End -->
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
export default {
    name: "Banner"
}
</script>

<style scoped>
.box-request{
    transform: translateY(50%);
}
</style>
