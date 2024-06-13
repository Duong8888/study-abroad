<template>
    <div class="row justify-content-center align-items-center custom-box">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-body p-4">
                    <router-link :to="{name:'Home'}">
                        <div class="text-center mb-4">
                            <img src="@/assets/images/common/logo.png" alt="" height="22" class="mx-auto logo-custom">
                            <h4 class="text-uppercase mt-0">Sign In</h4>
                        </div>
                    </router-link>


                    <form action="#">
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input class="form-control" type="email" v-model="email" id="emailaddress" required=""
                                   placeholder="Enter your email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" v-model="password" type="password" required="" id="password"
                                   placeholder="Enter your password">
                        </div>

                        <div class="mb-3">
<!--                            <div class="form-check">-->
<!--                                <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>-->
<!--                                <label class="form-check-label" for="checkbox-signin">Remember me</label>-->
<!--                            </div>-->
                        </div>

                        <div class="mb-3 d-grid text-center">
                            <button class="btn btn-primary w-100" @click="login({data: {email, password},toast: this.$toast})" type="button"> Log In</button>
                        </div>
                    </form>
<!--                    <div class="col-12 text-center">-->
<!--                        <p><a href="#" class="text-muted ms-1"><i class="fa fa-lock me-1"></i>Forgot your password?</a>-->
<!--                        </p>-->
<!--                    </div> -->

                    <!-- end col -->
                </div> <!-- end card-body -->
            </div>
            <!-- end card -->
            <!-- end row -->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
    <!-- end container -->
</template>

<script>
import {API_ENDPOINT} from "../../store/api-endpoint.js";
import api from '../../utils/axios.js';
import {mapActions} from "vuex";

export default {
    name: "Login",
    data() {
        return {
            email: '',
            password: '',
        }
    },
    methods: {
        ...mapActions('auth',['login']),
        // async login() {
        //     try {
        //         const response = await api.post(API_ENDPOINT.API_ADMIN.LOGIN, {
        //             email: this.email,
        //             password: this.password
        //         })
        //         const token = response.data.token;
        //         localStorage.setItem('authToken', token);
        //         this.$toast.open({
        //             message: 'SMARTEDU xin chào admin.',
        //             type: 'success',
        //             position: 'top'
        //         });
        //         await this.$router.push('/admin/request');
        //     } catch (e) {
        //         this.$toast.open({
        //             message: 'Sai tên đăng nhập hoặc mật khẩu.',
        //             type: 'error',
        //             position: 'top'
        //         });
        //     }
        // }
    },
}
</script>

<style scoped>
.logo-custom {
    width: 50px;
    height: 50px;
    margin-bottom: 15px;
    object-fit: cover;
}

.custom-box {
    overflow: hidden;
    height: 100vh;
    background: url("@/assets/images/common/banner-2.jpg") no-repeat;
    position: center;
    background-size: cover;
}
</style>
