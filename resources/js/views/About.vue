<template>
    <button @click="showToast">Hiển thị Toast</button>
</template>

<script>
export default {
    name: "About",
    methods: {
        showToast() {
            this.$toast.open({
                message: 'Something went wrong!',
                type: 'success',
                position: 'top',
            });
        }
    }
};
</script>
