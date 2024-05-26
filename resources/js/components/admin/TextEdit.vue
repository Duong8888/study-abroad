<template>
    <div class="w-100 mb-50">
        <div ref="summernote"></div>
<!--        <div class="py-4 d-flex justify-content-end">-->
<!--            <button class="btn btn-light mx-1" @click="edit">Edit</button>-->
<!--            <button class="btn btn-primary" @click="save">View</button>-->
<!--        </div>-->
    </div>
</template>

<script>
// import '../../assets/summernote/jquery/jquery-3.4.1.slim.min.js';
import '../../assets/summernote/summernote-lite.min.js';
import '../../assets/summernote/lang/summernote-vi-VN.min';
import '../../assets/summernote/summernote-lite.min.css';

export default {
    mounted() {
        this.edit();
    },
    methods: {
        edit() {
            $(this.$refs.summernote).summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear', 'italic', 'fontname']],
                    ['color', ['color']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['codeview', 'help',]],
                    ['hr', ['hr']],
                    ['undo', ['undo']],
                    ['redo', ['redo']],
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather', 'Times New Roman'],
                fontNamesIgnoreCheck: ['Merriweather'],
                lang: 'vi-VN',
                callbacks: {
                    onChange: (contents) => {
                        this.$emit('content', contents);
                    }
                }
            });
        },
        // save() {
        //     var markup = $(this.$refs.summernote).summernote('code');
        //     $(this.$refs.summernote).summernote('destroy');
        // },
    },
    beforeDestroy() {
        $(this.$refs.summernote).summernote('destroy');
    }
};
</script>

<style scoped>

</style>
