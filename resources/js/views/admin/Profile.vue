<template>
    <div class="container mt-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="true">Thông tin
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button"
                        role="tab" aria-controls="edit" aria-selected="false">Chỉnh sửa
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="change-password-tab" data-bs-toggle="tab" data-bs-target="#change-password"
                        type="button"
                        role="tab" aria-controls="change-password" aria-selected="false">Đổi mật khẩu
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Thông tin cá nhân</h5>
                        <p>Họ tên: {{ name }}</p>
                        <p>Email: {{ email }}</p>
                        <!-- Thêm thông tin cá nhân khác tại đây -->
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" @submit.prevent="updateProfile"
                              novalidate="novalidate">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <div v-if="error" class="alert alert-danger" role="alert">
                                        {{ error }}
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Họ tên</label>
                                    <input class="form-control" type="text" id="name" v-model="name" required/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="email" id="email" v-model="email" required/>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2 waves-effect waves-light"
                                        :class="{'btn-custom-disabled':btn}" :disabled="btn">
                                    Lưu thay đổi
                                    <div v-if="btn" class="spinner-border text-white spinner-custom" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="formChangePassword" method="POST" @submit.prevent="changePassword"
                              novalidate="novalidate">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <div v-if="error" class="alert alert-danger" role="alert">
                                        {{ error }}
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="currentPassword" class="form-label">Mật khẩu cũ</label>
                                    <div class="input-group">
                                        <input class="form-control" :type="!showPassword.currentPassword ?'password': 'text'" id="currentPassword"
                                               v-model="currentPassword" required/>
                                        <button class="btn btn-outline-secondary" type="button" @click="togglePassword('currentPassword')">
                                            <i v-if="showPassword.currentPassword" class="fa fa-eye-slash"></i>
                                            <i v-else class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="newPassword" class="form-label">Mật khẩu mới</label>
                                    <div class="input-group">
                                        <input class="form-control" :type="!showPassword.newPassword ?'password': 'text'" id="newPassword" v-model="newPassword"
                                               required/>
                                        <button class="btn btn-outline-secondary" type="button" @click="togglePassword('newPassword')">
                                            <i v-if="showPassword.newPassword" class="fa fa-eye-slash"></i>
                                            <i v-else class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="confirmNewPassword" class="form-label">Nhập lại mật khẩu mới</label>
                                    <div class="input-group">
                                        <input class="form-control" :type="!showPassword.confirmNewPassword ?'password': 'text'" id="confirmNewPassword"
                                               v-model="confirmNewPassword" required/>
                                        <button class="btn btn-outline-secondary" type="button" @click="togglePassword('confirmNewPassword')">
                                            <i v-if="showPassword.confirmNewPassword" class="fa fa-eye-slash"></i>
                                            <i v-else class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2 waves-effect waves-light"
                                        :class="{'btn-custom-disabled':btn}" :disabled="btn">
                                    Lưu thay đổi
                                    <div v-if="btn" class="spinner-border text-white spinner-custom" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect">Hủy</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Profile",
    data() {
        return {
            name: "",
            email: "",
            currentPassword: "",
            newPassword: "",
            confirmNewPassword: "",
            error: "",
            btn: false,
            showPassword: {
                currentPassword: false,
                newPassword: false,
                confirmNewPassword: false,
            }
        };
    },
    watch: {
        userInfo: function (newValue) {
            this.name = newValue.name;
            this.email = newValue.email;
        },
        statusBtn: function (newValue) {
            this.btn = newValue
        }
    },
    computed: {
        ...mapGetters('auth', ['userInfo', 'statusBtn']),
    },
    created() {
        this.getUser();
    },
    methods: {
        ...mapActions('auth', ['getUser', 'updateUser', 'changePass']),
        togglePassword(field) {
            this.showPassword[field] = !this.showPassword[field];
        },
        checkEmailFormat(email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(this.email)) {
                this.error = "Email không đúng định dạng.";
            }
        },
        async updateProfile() {
            if (this.name === '' || this.email === '') {
                this.error = "Vui lòng nhập đủ thông tin.";
                return;
            }
            this.checkEmailFormat(this.email);
            await this.updateUser({data: {name: this.name, email: this.email}, toast: this.$toast})
        },
        async changePassword() {
            if (this.newPassword !== this.confirmNewPassword) {
                this.error = "Nhập lại mật khẩu mới không khớp !";
                return;
            }
            await this.changePass({
                data: {
                    current_password: this.currentPassword,
                    new_password: this.newPassword,
                    new_password_confirmation: this.confirmNewPassword
                }, toast: this.$toast
            })
        }
    }
};
</script>

<style scoped>
.container {
    margin-top: 20px;
}

.card {
    margin-top: 20px;
}

.btn {
    margin-right: 10px;
}

.nav-tabs .nav-link.active {
    background-color: #007bff;
    color: white;
}

.spinner-custom {
    width: 20px;
    height: 20px;
}

.btn-custom-disabled {
    opacity: 0.5;
    user-select: none;
}

.btn-custom-disabled:hover {
    opacity: 0.5 !important;
}
</style>
