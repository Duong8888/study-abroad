<!--<script setup>-->
<!--import Editor from '@tinymce/tinymce-vue';-->
<!--</script>-->

<template>
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{
                        formType ? "Tạo mới bài viết" : "Chỉnh sửa bài viết"
                    }}</h6>
            </div>
            <div class="col-12 pt-2 d-flex justify-content-end">
                <div class="alert alert-danger w-100" role="alert" v-if="globalError">
                    {{ globalError }}
                </div>
            </div>
            <div class="row p-4" style="padding-top: 0 !important;">
                <div class="col-12">
                    <div class="w-100">
                        <label for="inputTitle" class="form-label mt-20">Tiêu đề</label>
                        <input type="text" class="form-control" id="inputTitle" placeholder="Title"
                               v-model="title" aria-label="Title">
                        <div v-if="errors.title" class="text-danger">{{ errors.title }}</div>
                    </div>
                    <div class="w-100">
                        <label for="inputSlug" class="form-label mt-20">Slug</label>
                        <input type="text" class="form-control" id="inputSlug" placeholder="Slug"
                               v-model="slug"
                               aria-label="Slug">
                        <div v-if="errors.slug" class="text-danger">{{ errors.slug }}</div>
                    </div>
                    <div class="w-100 mb-20">
                        <label for="inputSlug" class="form-label mt-20">Danh mục bài viết</label>
                        <Multiselect class="form-label"
                                     v-model="values"
                                     mode="tags"
                                     :close-on-select="false"
                                     :searchable="true"
                                     :create-option="true"
                                     :options="category"
                                     :taggable="true"
                                     label="label"
                        />
                        <div v-if="errors.category" class="text-danger">{{ errors.category }}</div>
                    </div>

                    <div class="w-100 mb-20">
                        <label for="inputSlug" class="form-label">Mô tả ngắn</label>
                        <textarea name="description" v-model="description" placeholder="Description"
                                  class="form-control"></textarea>
                        <div v-if="errors.description" class="text-danger">{{ errors.description }}</div>
                    </div>
                </div>
            </div>
            <main id="sample" class="p-4" style="padding-top: 0px !important;">
                <label for="university" class="form-label mb-20 d-flex align-items-center">
                    <span>Thông tin trường</span>
                    <input style="margin-left: 5px; width: 15px;height: 15px;" :checked="subContent" v-model="subContent"
                           type="checkbox" id="university">
                </label>
                <div v-show="subContent">
                    <textarea ref="editor1">{{ contentUniversity }}</textarea>
<!--                    <Editor-->
<!--                        v-model="contentUniversity"-->
<!--                        :api-key="apiKey"-->
<!--                        :init="{...editorConfig,height: 500}"-->
<!--                    />-->
                </div>


                <label for="inputSlug" class="form-label mb-20 mt-20">Nội dung bài</label>
                <textarea ref="editor2">{{ editorContent }}</textarea>
<!--                <Editor-->
<!--                    v-model="editorContent"-->
<!--                    :api-key="apiKey"-->
<!--                    :init="{...editorConfig,height: 800}"-->
<!--                />-->
                <div v-if="errors.editorContent" class="text-danger">{{ errors.editorContent }}</div>
            </main>
            <div class="col-12">
                <input hidden type="file" class="form-control" id="imageInput" ref="imageInput"
                       @change="previewImage"
                       accept="image/*">
                <label for="imageInput" class="form-label box-img">
                    <p v-if="!imageUrl" class="d-flex flex-column align-items-center justify-content-center">
                        <span>Thumbnail</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24"
                             style="fill: #cccc;transform: ;msFilter:;">
                            <path
                                d="M4 5h13v7h2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-2H4V5z"></path>
                            <path d="m8 11-3 4h11l-4-6-3 4z"></path>
                            <path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z"></path>
                        </svg>
                    </p>
                    <img v-if="imageUrl" :src="imageUrl" class="" alt="Preview" style="max-width: 100%">
                </label>
                <div v-if="errors.imageUrl" class="text-danger">{{ errors.imageUrl }}</div>
            </div>
            <div class="col-12 py-4 d-flex justify-content-end">
                <router-link :to="{name:'Posts'}">
                    <button class="btn btn-light mx-1">Hủy</button>
                </router-link>
                <button class="btn btn-primary" @click="actionBtn(getData)">{{ formType ? "Lưu" : "Cập nhật" }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import TextEdit from '../../components/admin/TextEdit.vue';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import {mapGetters, mapActions} from "vuex";

export default {
    name: "PostsAdd",
    data() {
        return {
            title: '',
            slug: '',
            imageUrl: null,
            values: [],
            description: null,
            thumbnail: null,
            editorContent: this.value,
            formType: true,
            id: null,
            errors: {},
            globalError: '',
            subContent: false,
            contentUniversity:
                `<div>
                    <div style="display: flex; border: 1px solid #ccc; padding: 20px; width: 100%; height: auto;box-sizing: border-box;">
                        <div style="padding-right: 20px; width: 80%">
                            <ul style="list-style-type: none; padding: 0;">
                                <li style="padding-bottom: 15px; display: flex;align-items: center;line-height: 20px">
                                    <img width="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAAt1JREFUWEftlr9PU1EUx7/nVQqEVENb0JD2FWgbE+LGxmSiicEJE5M2cZAYR/gHnPBPcJJOjvhjEDVsPIUwODiQOJhAH0JLm0iwtSKIhb57tETw0fb9ajsQ07fe7z3nc7/nnHsf4Yx9dMZ40AKyqsj/5xADRABbndzuel0OJSORdm+Rx0B0i4AxJrwDWJFASndKXbabvJbONlAVBNBukDhLgCLACoRL8WdWs04ATYEcQBjmZGCZmBSwULyR4DwtLJTMAKuAmgFhQleChHmz8p4CysmRp0c9YVwOJ+7b0R6V15tW7x6LK4GaNi12aI41vrR6wnEKqCCHhwWkGIPjAIJOgtajJeIZTaNET0ZdrOmQPmg+FB5llmIAxwB01JPQYM+eRJg+1ESiN/M5WamxHPv1/v4Oj3DFiCkGwmgDYEnBnNAOuqYvbX3cM4pjCaTfmOsLB0Ub4mU4AobtwBFhUROU6NlMztjSG4nywXD8u0ubHdjY+FVLY9VvtfrjOM5XOXrd5+YlUtWi7ZLl5Eh54n4CmAPwYkcqvTGC0/XbbaP+2AwEOruoY5wJEwCG4MYFn6ruOAXS6x/60uqUmXNTgDQFCP2mghwd1IgnwLgPwHOy1iwgO86V/wDygfANSNIkwOVBqO7VJgPpTdgH8JqJnrcXeano5jiBJgFEzZpY23d7erc/7TZcsr8O2RkYc02jDjHhsS+lTuTliNY4DSA6Xed7VlZ+OHFoA0CoYsMWgIsNAxFWvSl1iICqwxlejPnQ4E1maRZAW8MAFQGY+Jo/tfa2VlzTmzoXCo+A6RUAf5OgCkx8z59ae1n301GQ5W4B9yMG7uDPPVMnWLk0T9wHeOD5om6bxbD9lm0HL/cRtHEiXAUwAqDLAu4QwHsCzZGr9Kx7fT1l5zC2gfTBGJC+BQauMJ0bBvG/xifSAM5KgtRd3v8QzGTKd5Sjry4gRxkciltAVoa1HGo5ZOWA1fpvg7I8NKBHGhYAAAAASUVORK5CYII="/>
                                    <span style="font-weight: bold">Tên tiếng Hàn: </span>
                                </li>

                                <li style="padding-bottom: 15px; display: flex;align-items: center;line-height: 20px">
                                    <img width="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAAt1JREFUWEftlr9PU1EUx7/nVQqEVENb0JD2FWgbE+LGxmSiicEJE5M2cZAYR/gHnPBPcJJOjvhjEDVsPIUwODiQOJhAH0JLm0iwtSKIhb57tETw0fb9ajsQ07fe7z3nc7/nnHsf4Yx9dMZ40AKyqsj/5xADRABbndzuel0OJSORdm+Rx0B0i4AxJrwDWJFASndKXbabvJbONlAVBNBukDhLgCLACoRL8WdWs04ATYEcQBjmZGCZmBSwULyR4DwtLJTMAKuAmgFhQleChHmz8p4CysmRp0c9YVwOJ+7b0R6V15tW7x6LK4GaNi12aI41vrR6wnEKqCCHhwWkGIPjAIJOgtajJeIZTaNET0ZdrOmQPmg+FB5llmIAxwB01JPQYM+eRJg+1ESiN/M5WamxHPv1/v4Oj3DFiCkGwmgDYEnBnNAOuqYvbX3cM4pjCaTfmOsLB0Ub4mU4AobtwBFhUROU6NlMztjSG4nywXD8u0ubHdjY+FVLY9VvtfrjOM5XOXrd5+YlUtWi7ZLl5Eh54n4CmAPwYkcqvTGC0/XbbaP+2AwEOruoY5wJEwCG4MYFn6ruOAXS6x/60uqUmXNTgDQFCP2mghwd1IgnwLgPwHOy1iwgO86V/wDygfANSNIkwOVBqO7VJgPpTdgH8JqJnrcXeano5jiBJgFEzZpY23d7erc/7TZcsr8O2RkYc02jDjHhsS+lTuTliNY4DSA6Xed7VlZ+OHFoA0CoYsMWgIsNAxFWvSl1iICqwxlejPnQ4E1maRZAW8MAFQGY+Jo/tfa2VlzTmzoXCo+A6RUAf5OgCkx8z59ae1n301GQ5W4B9yMG7uDPPVMnWLk0T9wHeOD5om6bxbD9lm0HL/cRtHEiXAUwAqDLAu4QwHsCzZGr9Kx7fT1l5zC2gfTBGJC+BQauMJ0bBvG/xifSAM5KgtRd3v8QzGTKd5Sjry4gRxkciltAVoa1HGo5ZOWA1fpvg7I8NKBHGhYAAAAASUVORK5CYII="/>
                                    <span style="font-weight: bold">Tên tiếng Anh: </span>
                                </li>
                                <li style="padding-bottom: 15px; display: flex;align-items: center;line-height: 20px">
                                    <img width="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAAt1JREFUWEftlr9PU1EUx7/nVQqEVENb0JD2FWgbE+LGxmSiicEJE5M2cZAYR/gHnPBPcJJOjvhjEDVsPIUwODiQOJhAH0JLm0iwtSKIhb57tETw0fb9ajsQ07fe7z3nc7/nnHsf4Yx9dMZ40AKyqsj/5xADRABbndzuel0OJSORdm+Rx0B0i4AxJrwDWJFASndKXbabvJbONlAVBNBukDhLgCLACoRL8WdWs04ATYEcQBjmZGCZmBSwULyR4DwtLJTMAKuAmgFhQleChHmz8p4CysmRp0c9YVwOJ+7b0R6V15tW7x6LK4GaNi12aI41vrR6wnEKqCCHhwWkGIPjAIJOgtajJeIZTaNET0ZdrOmQPmg+FB5llmIAxwB01JPQYM+eRJg+1ESiN/M5WamxHPv1/v4Oj3DFiCkGwmgDYEnBnNAOuqYvbX3cM4pjCaTfmOsLB0Ub4mU4AobtwBFhUROU6NlMztjSG4nywXD8u0ubHdjY+FVLY9VvtfrjOM5XOXrd5+YlUtWi7ZLl5Eh54n4CmAPwYkcqvTGC0/XbbaP+2AwEOruoY5wJEwCG4MYFn6ruOAXS6x/60uqUmXNTgDQFCP2mghwd1IgnwLgPwHOy1iwgO86V/wDygfANSNIkwOVBqO7VJgPpTdgH8JqJnrcXeano5jiBJgFEzZpY23d7erc/7TZcsr8O2RkYc02jDjHhsS+lTuTliNY4DSA6Xed7VlZ+OHFoA0CoYsMWgIsNAxFWvSl1iICqwxlejPnQ4E1maRZAW8MAFQGY+Jo/tfa2VlzTmzoXCo+A6RUAf5OgCkx8z59ae1n301GQ5W4B9yMG7uDPPVMnWLk0T9wHeOD5om6bxbD9lm0HL/cRtHEiXAUwAqDLAu4QwHsCzZGr9Kx7fT1l5zC2gfTBGJC+BQauMJ0bBvG/xifSAM5KgtRd3v8QzGTKd5Sjry4gRxkciltAVoa1HGo5ZOWA1fpvg7I8NKBHGhYAAAAASUVORK5CYII="/>
                                    <span style="font-weight: bold">Đối tác tuyển sinh tại Việt Nam: </span>
                                </li>
                                <li style="padding-bottom: 15px; display: flex;align-items: center;line-height: 20px">
                                    <img width="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAAt1JREFUWEftlr9PU1EUx7/nVQqEVENb0JD2FWgbE+LGxmSiicEJE5M2cZAYR/gHnPBPcJJOjvhjEDVsPIUwODiQOJhAH0JLm0iwtSKIhb57tETw0fb9ajsQ07fe7z3nc7/nnHsf4Yx9dMZ40AKyqsj/5xADRABbndzuel0OJSORdm+Rx0B0i4AxJrwDWJFASndKXbabvJbONlAVBNBukDhLgCLACoRL8WdWs04ATYEcQBjmZGCZmBSwULyR4DwtLJTMAKuAmgFhQleChHmz8p4CysmRp0c9YVwOJ+7b0R6V15tW7x6LK4GaNi12aI41vrR6wnEKqCCHhwWkGIPjAIJOgtajJeIZTaNET0ZdrOmQPmg+FB5llmIAxwB01JPQYM+eRJg+1ESiN/M5WamxHPv1/v4Oj3DFiCkGwmgDYEnBnNAOuqYvbX3cM4pjCaTfmOsLB0Ub4mU4AobtwBFhUROU6NlMztjSG4nywXD8u0ubHdjY+FVLY9VvtfrjOM5XOXrd5+YlUtWi7ZLl5Eh54n4CmAPwYkcqvTGC0/XbbaP+2AwEOruoY5wJEwCG4MYFn6ruOAXS6x/60uqUmXNTgDQFCP2mghwd1IgnwLgPwHOy1iwgO86V/wDygfANSNIkwOVBqO7VJgPpTdgH8JqJnrcXeano5jiBJgFEzZpY23d7erc/7TZcsr8O2RkYc02jDjHhsS+lTuTliNY4DSA6Xed7VlZ+OHFoA0CoYsMWgIsNAxFWvSl1iICqwxlejPnQ4E1maRZAW8MAFQGY+Jo/tfa2VlzTmzoXCo+A6RUAf5OgCkx8z59ae1n301GQ5W4B9yMG7uDPPVMnWLk0T9wHeOD5om6bxbD9lm0HL/cRtHEiXAUwAqDLAu4QwHsCzZGr9Kx7fT1l5zC2gfTBGJC+BQauMJ0bBvG/xifSAM5KgtRd3v8QzGTKd5Sjry4gRxkciltAVoa1HGo5ZOWA1fpvg7I8NKBHGhYAAAAASUVORK5CYII="/>
                                    <span style="font-weight: bold">Năm thành lập: </span>
                                </li>
                                <li style="padding-bottom: 15px; display: flex;align-items: center;line-height: 20px">
                                    <img width="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAAt1JREFUWEftlr9PU1EUx7/nVQqEVENb0JD2FWgbE+LGxmSiicEJE5M2cZAYR/gHnPBPcJJOjvhjEDVsPIUwODiQOJhAH0JLm0iwtSKIhb57tETw0fb9ajsQ07fe7z3nc7/nnHsf4Yx9dMZ40AKyqsj/5xADRABbndzuel0OJSORdm+Rx0B0i4AxJrwDWJFASndKXbabvJbONlAVBNBukDhLgCLACoRL8WdWs04ATYEcQBjmZGCZmBSwULyR4DwtLJTMAKuAmgFhQleChHmz8p4CysmRp0c9YVwOJ+7b0R6V15tW7x6LK4GaNi12aI41vrR6wnEKqCCHhwWkGIPjAIJOgtajJeIZTaNET0ZdrOmQPmg+FB5llmIAxwB01JPQYM+eRJg+1ESiN/M5WamxHPv1/v4Oj3DFiCkGwmgDYEnBnNAOuqYvbX3cM4pjCaTfmOsLB0Ub4mU4AobtwBFhUROU6NlMztjSG4nywXD8u0ubHdjY+FVLY9VvtfrjOM5XOXrd5+YlUtWi7ZLl5Eh54n4CmAPwYkcqvTGC0/XbbaP+2AwEOruoY5wJEwCG4MYFn6ruOAXS6x/60uqUmXNTgDQFCP2mghwd1IgnwLgPwHOy1iwgO86V/wDygfANSNIkwOVBqO7VJgPpTdgH8JqJnrcXeano5jiBJgFEzZpY23d7erc/7TZcsr8O2RkYc02jDjHhsS+lTuTliNY4DSA6Xed7VlZ+OHFoA0CoYsMWgIsNAxFWvSl1iICqwxlejPnQ4E1maRZAW8MAFQGY+Jo/tfa2VlzTmzoXCo+A6RUAf5OgCkx8z59ae1n301GQ5W4B9yMG7uDPPVMnWLk0T9wHeOD5om6bxbD9lm0HL/cRtHEiXAUwAqDLAu4QwHsCzZGr9Kx7fT1l5zC2gfTBGJC+BQauMJ0bBvG/xifSAM5KgtRd3v8QzGTKd5Sjry4gRxkciltAVoa1HGo5ZOWA1fpvg7I8NKBHGhYAAAAASUVORK5CYII="/>
                                    <span style="font-weight: bold">Số lượng sinh viên: </span>
                                </li>
                                <li style="padding-bottom: 15px; display: flex;align-items: center;line-height: 20px">
                                    <img width="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAAt1JREFUWEftlr9PU1EUx7/nVQqEVENb0JD2FWgbE+LGxmSiicEJE5M2cZAYR/gHnPBPcJJOjvhjEDVsPIUwODiQOJhAH0JLm0iwtSKIhb57tETw0fb9ajsQ07fe7z3nc7/nnHsf4Yx9dMZ40AKyqsj/5xADRABbndzuel0OJSORdm+Rx0B0i4AxJrwDWJFASndKXbabvJbONlAVBNBukDhLgCLACoRL8WdWs04ATYEcQBjmZGCZmBSwULyR4DwtLJTMAKuAmgFhQleChHmz8p4CysmRp0c9YVwOJ+7b0R6V15tW7x6LK4GaNi12aI41vrR6wnEKqCCHhwWkGIPjAIJOgtajJeIZTaNET0ZdrOmQPmg+FB5llmIAxwB01JPQYM+eRJg+1ESiN/M5WamxHPv1/v4Oj3DFiCkGwmgDYEnBnNAOuqYvbX3cM4pjCaTfmOsLB0Ub4mU4AobtwBFhUROU6NlMztjSG4nywXD8u0ubHdjY+FVLY9VvtfrjOM5XOXrd5+YlUtWi7ZLl5Eh54n4CmAPwYkcqvTGC0/XbbaP+2AwEOruoY5wJEwCG4MYFn6ruOAXS6x/60uqUmXNTgDQFCP2mghwd1IgnwLgPwHOy1iwgO86V/wDygfANSNIkwOVBqO7VJgPpTdgH8JqJnrcXeano5jiBJgFEzZpY23d7erc/7TZcsr8O2RkYc02jDjHhsS+lTuTliNY4DSA6Xed7VlZ+OHFoA0CoYsMWgIsNAxFWvSl1iICqwxlejPnQ4E1maRZAW8MAFQGY+Jo/tfa2VlzTmzoXCo+A6RUAf5OgCkx8z59ae1n301GQ5W4B9yMG7uDPPVMnWLk0T9wHeOD5om6bxbD9lm0HL/cRtHEiXAUwAqDLAu4QwHsCzZGr9Kx7fT1l5zC2gfTBGJC+BQauMJ0bBvG/xifSAM5KgtRd3v8QzGTKd5Sjry4gRxkciltAVoa1HGo5ZOWA1fpvg7I8NKBHGhYAAAAASUVORK5CYII="/>
                                    <span style="font-weight: bold">Học phí tiếng Hàn: </span>
                                </li>
                                <li style="padding-bottom: 15px; display: flex;align-items: center;line-height: 20px">
                                    <img width="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAAt1JREFUWEftlr9PU1EUx7/nVQqEVENb0JD2FWgbE+LGxmSiicEJE5M2cZAYR/gHnPBPcJJOjvhjEDVsPIUwODiQOJhAH0JLm0iwtSKIhb57tETw0fb9ajsQ07fe7z3nc7/nnHsf4Yx9dMZ40AKyqsj/5xADRABbndzuel0OJSORdm+Rx0B0i4AxJrwDWJFASndKXbabvJbONlAVBNBukDhLgCLACoRL8WdWs04ATYEcQBjmZGCZmBSwULyR4DwtLJTMAKuAmgFhQleChHmz8p4CysmRp0c9YVwOJ+7b0R6V15tW7x6LK4GaNi12aI41vrR6wnEKqCCHhwWkGIPjAIJOgtajJeIZTaNET0ZdrOmQPmg+FB5llmIAxwB01JPQYM+eRJg+1ESiN/M5WamxHPv1/v4Oj3DFiCkGwmgDYEnBnNAOuqYvbX3cM4pjCaTfmOsLB0Ub4mU4AobtwBFhUROU6NlMztjSG4nywXD8u0ubHdjY+FVLY9VvtfrjOM5XOXrd5+YlUtWi7ZLl5Eh54n4CmAPwYkcqvTGC0/XbbaP+2AwEOruoY5wJEwCG4MYFn6ruOAXS6x/60uqUmXNTgDQFCP2mghwd1IgnwLgPwHOy1iwgO86V/wDygfANSNIkwOVBqO7VJgPpTdgH8JqJnrcXeano5jiBJgFEzZpY23d7erc/7TZcsr8O2RkYc02jDjHhsS+lTuTliNY4DSA6Xed7VlZ+OHFoA0CoYsMWgIsNAxFWvSl1iICqwxlejPnQ4E1maRZAW8MAFQGY+Jo/tfa2VlzTmzoXCo+A6RUAf5OgCkx8z59ae1n301GQ5W4B9yMG7uDPPVMnWLk0T9wHeOD5om6bxbD9lm0HL/cRtHEiXAUwAqDLAu4QwHsCzZGr9Kx7fT1l5zC2gfTBGJC+BQauMJ0bBvG/xifSAM5KgtRd3v8QzGTKd5Sjry4gRxkciltAVoa1HGo5ZOWA1fpvg7I8NKBHGhYAAAAASUVORK5CYII="/>
                                    <span style="font-weight: bold">Ký túc xá: </span>
                                </li>
                                <li style="padding-bottom: 15px; display: flex;align-items: center;line-height: 20px">
                                    <img width="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAAt1JREFUWEftlr9PU1EUx7/nVQqEVENb0JD2FWgbE+LGxmSiicEJE5M2cZAYR/gHnPBPcJJOjvhjEDVsPIUwODiQOJhAH0JLm0iwtSKIhb57tETw0fb9ajsQ07fe7z3nc7/nnHsf4Yx9dMZ40AKyqsj/5xADRABbndzuel0OJSORdm+Rx0B0i4AxJrwDWJFASndKXbabvJbONlAVBNBukDhLgCLACoRL8WdWs04ATYEcQBjmZGCZmBSwULyR4DwtLJTMAKuAmgFhQleChHmz8p4CysmRp0c9YVwOJ+7b0R6V15tW7x6LK4GaNi12aI41vrR6wnEKqCCHhwWkGIPjAIJOgtajJeIZTaNET0ZdrOmQPmg+FB5llmIAxwB01JPQYM+eRJg+1ESiN/M5WamxHPv1/v4Oj3DFiCkGwmgDYEnBnNAOuqYvbX3cM4pjCaTfmOsLB0Ub4mU4AobtwBFhUROU6NlMztjSG4nywXD8u0ubHdjY+FVLY9VvtfrjOM5XOXrd5+YlUtWi7ZLl5Eh54n4CmAPwYkcqvTGC0/XbbaP+2AwEOruoY5wJEwCG4MYFn6ruOAXS6x/60uqUmXNTgDQFCP2mghwd1IgnwLgPwHOy1iwgO86V/wDygfANSNIkwOVBqO7VJgPpTdgH8JqJnrcXeano5jiBJgFEzZpY23d7erc/7TZcsr8O2RkYc02jDjHhsS+lTuTliNY4DSA6Xed7VlZ+OHFoA0CoYsMWgIsNAxFWvSl1iICqwxlejPnQ4E1maRZAW8MAFQGY+Jo/tfa2VlzTmzoXCo+A6RUAf5OgCkx8z59ae1n301GQ5W4B9yMG7uDPPVMnWLk0T9wHeOD5om6bxbD9lm0HL/cRtHEiXAUwAqDLAu4QwHsCzZGr9Kx7fT1l5zC2gfTBGJC+BQauMJ0bBvG/xifSAM5KgtRd3v8QzGTKd5Sjry4gRxkciltAVoa1HGo5ZOWA1fpvg7I8NKBHGhYAAAAASUVORK5CYII="/>
                                    <span style="font-weight: bold">Địa chỉ: </span>
                                </li>
                                <li style="padding-bottom: 15px; display: flex;align-items: center;line-height: 20px">
                                    <img width="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAAt1JREFUWEftlr9PU1EUx7/nVQqEVENb0JD2FWgbE+LGxmSiicEJE5M2cZAYR/gHnPBPcJJOjvhjEDVsPIUwODiQOJhAH0JLm0iwtSKIhb57tETw0fb9ajsQ07fe7z3nc7/nnHsf4Yx9dMZ40AKyqsj/5xADRABbndzuel0OJSORdm+Rx0B0i4AxJrwDWJFASndKXbabvJbONlAVBNBukDhLgCLACoRL8WdWs04ATYEcQBjmZGCZmBSwULyR4DwtLJTMAKuAmgFhQleChHmz8p4CysmRp0c9YVwOJ+7b0R6V15tW7x6LK4GaNi12aI41vrR6wnEKqCCHhwWkGIPjAIJOgtajJeIZTaNET0ZdrOmQPmg+FB5llmIAxwB01JPQYM+eRJg+1ESiN/M5WamxHPv1/v4Oj3DFiCkGwmgDYEnBnNAOuqYvbX3cM4pjCaTfmOsLB0Ub4mU4AobtwBFhUROU6NlMztjSG4nywXD8u0ubHdjY+FVLY9VvtfrjOM5XOXrd5+YlUtWi7ZLl5Eh54n4CmAPwYkcqvTGC0/XbbaP+2AwEOruoY5wJEwCG4MYFn6ruOAXS6x/60uqUmXNTgDQFCP2mghwd1IgnwLgPwHOy1iwgO86V/wDygfANSNIkwOVBqO7VJgPpTdgH8JqJnrcXeano5jiBJgFEzZpY23d7erc/7TZcsr8O2RkYc02jDjHhsS+lTuTliNY4DSA6Xed7VlZ+OHFoA0CoYsMWgIsNAxFWvSl1iICqwxlejPnQ4E1maRZAW8MAFQGY+Jo/tfa2VlzTmzoXCo+A6RUAf5OgCkx8z59ae1n301GQ5W4B9yMG7uDPPVMnWLk0T9wHeOD5om6bxbD9lm0HL/cRtHEiXAUwAqDLAu4QwHsCzZGr9Kx7fT1l5zC2gfTBGJC+BQauMJ0bBvG/xifSAM5KgtRd3v8QzGTKd5Sjry4gRxkciltAVoa1HGo5ZOWA1fpvg7I8NKBHGhYAAAAASUVORK5CYII="/>
                                    <span style="font-weight: bold">Website: </span>
                                </li>
                            </ul>
                        </div>
                        <div style="display: flex; flex-direction: column; justify-content: space-between; width: 20%">
                            <img src="https://via.placeholder.com/150" alt="logo-university" style="align-self: flex-end;">
                            <img src="https://via.placeholder.com/150" alt="qr-university" style="align-self: flex-end;">
                        </div>
                    </div>
                    <p>I. Smart edu<h1>
                    <p>II. Smart edu<h1>
                    <p>III. Smart edu<h1>
                </div>`,
            // apiKey: 'ok7t7t5acz8af0vod6gap5of3whu45jtqowlv37j3kao6s7y',
            editorConfig: {
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
                toolbar: 'undo redo | blocks fontfamily fontsize | forecolor bold italic underline strikethrough | link image media table | addcomment showcomments | spellcheckdialog a11ycheck | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image',

                file_picker_callback: (cb, value, meta) => {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.addEventListener('change', (e) => {
                        const file = e.target.files[0];
                        const formData = new FormData();
                        formData.append('upload', file);

                        axios.post('/api/upload-image', formData)
                            .then(response => {
                                const imageUrl = response.data.url;
                                cb(imageUrl, {title: file.name});
                                console.log('File uploaded successfully:', imageUrl);
                            })
                            .catch(error => {
                                console.error('Error uploading file:', error);
                            });
                    });

                    input.click();
                },
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
                // tinycomments_mode: 'embedded',
                // tinycomments_author: 'Author name',
            }
        };
    },
    watch: {
        title: function (newTitle) {
            if (this.formType) {
                this.slug = this.createSlug(newTitle);
            }
        },
        contentUniversity(newContent) {
            if (this.$refs.editor1 && tinymce.get(this.$refs.editor1.id)) {
                tinymce.get(this.$refs.editor1.id).setContent(newContent);
            }
        },
        editorContent(newContent) {
            if (this.$refs.editor2 && tinymce.get(this.$refs.editor2.id)) {
                tinymce.get(this.$refs.editor2.id).setContent(newContent);
            }
        },
        showData: {
            handler(newValue) {
                if (newValue && newValue.data) {
                    const {title, slug, thumbnail, content, description, post_type_id, type, university_info} = newValue.data;
                    this.subContent = (type == "0") ? false : true;
                    this.title = title;
                    this.slug = slug;
                    // this.value = JSON.parse(post_type_id);
                    this.imageUrl = thumbnail;
                    this.editorContent = content;
                    this.description = description;
                    if(this.subContent){
                        this.contentUniversity = university_info;
                    }
                }
            },
            deep: true,
            immediate: true
        }
    },
    created() {
        this.fetchCategory();
        if (this.$route.params.postsId) {
            this.formType = false;
            this.id = this.$route.params.postsId;
            const postsId = this.$route.params.postsId;
            this.getDetailPosts(postsId);
        } else {
            this.title = '';
            this.slug = '';
            this.imageUrl = null;
            this.values = [];
            this.description = null;
            this.editorContent = `

            <h1 style="color: #b21818;text-transform: uppercase">I. Smart edu</h1>
            <h2 style="color: #b21818;font-weight: 200">1 Smart edu</h2>
            <h3 style="color: #b21818;font-weight: 200">1.1 Smart edu</h3>
            <h3 style="color: #b21818;font-weight: 200">1.2 Smart edu</h3>
            <h2 style="color: #b21818;font-weight: 200">2 Smart edu</h2>
            <h3 style="color: #b21818;font-weight: 200">2.1 Smart edu</h3>
            <h3 style="color: #b21818;font-weight: 200">2.2 Smart edu</h3>

            <h1 style="color: #b21818;text-transform: uppercase">II. Smart edu</h1>
            <h2 style="color: #b21818;font-weight: 200">1 Smart edu</h2>
            <h3 style="color: #b21818;font-weight: 200">1.1 Smart edu</h3>
            <h3 style="color: #b21818;font-weight: 200">1.2 Smart edu</h3>
            <h2 style="color: #b21818;font-weight: 200">2 Smart edu</h2>
            <h3 style="color: #b21818;font-weight: 200">2.1 Smart edu</h3>
            <h3 style="color: #b21818;font-weight: 200">2.2 Smart edu</h3>
            `;
            this.thumbnail = null;
            this.formType = true;
        }
    },
    mounted() {
        this.initTinyMCE();
    },
    methods: {
        ...mapActions('category', ['fetchCategory',]),
        ...mapActions('posts', ['addPost', 'getOnePost', 'updatePost']),
        createSlug(title) {
            let slug = title.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            slug = slug.toLowerCase().replace(/\s+/g, '-');
            return slug;
        },
        initTinyMCE() {
            tinymce.init({
                target: this.$refs.editor2,
                ...this.editorConfig,
                setup: (editor) => {
                    editor.on('change', () => {
                        this.editorContent = editor.getContent();
                    });
                    editor.on('init', () => {
                        editor.setContent(this.editorContent || '');
                    });
                },
            });

            tinymce.init({
                target: this.$refs.editor1,
                ...this.editorConfig,
                setup: (editor) => {
                    editor.on('change', () => {
                        this.contentUniversity = editor.getContent();
                    });
                    editor.on('init', () => {
                        editor.setContent(this.contentUniversity || '');
                    });
                },
            });
        },
        transformData(rawData) {
            let parsedData;
            try {
                parsedData = JSON.parse(rawData);
            } catch (error) {
                console.error('Invalid JSON string:', error);
                return [];
            }
            return parsedData.map(item => {
                return {
                    value: { id: item.id, name: item.name },
                    label: item.name
                };
            });
        },
        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    this.imageUrl = reader.result;
                    const formData = new FormData();
                    formData.append('upload', file);
                    axios.post('/api/upload-image', formData)
                        .then(response => {
                            this.thumbnail = response.data.url;
                            console.log('File uploaded successfully:', response.data);
                        })
                        .catch(error => {
                            console.error('Error uploading file:', error);
                        });
                };
                reader.readAsDataURL(file);
            }
        },
        validateForm() {
            this.errors = {};
            const slugRegex = /^[a-z0-9đ]+(?:-[a-z0-9đ]+)*$/;
            if (!this.title) this.errors.title = "Vui lòng nhập tiêu đề.";
            if (!this.slug) {
                this.errors.slug = "Vui lòng nhập slug.";
            } else if (!slugRegex.test(this.slug)) {
                this.errors.slug = "Slug không hợp lệ. Chỉ chấp nhận chữ thường, số và dấu gạch ngang.";
            }
            if (!this.values.length) this.errors.category = "Vui lòng chọn danh mục.";
            if (!this.description) this.errors.description = "Vui lòng nhập mô tả.";
            if (!this.editorContent) this.errors.editorContent = "Vui lòng nhập nội dung.";
            if (!this.imageUrl) this.errors.imageUrl = "Vui lòng chọn ảnh.";

            const isValid = Object.keys(this.errors).length === 0;
            if (!isValid) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
            return isValid;
        },
        addNewPosts(data) {
            this.addPost({data: data, toast: this.$toast})
        },
        updatePosts(data) {
            this.updatePost({data: data, toast: this.$toast})
        },
        getDetailPosts(id) {
            this.getOnePost(id);
        },
        actionBtn(data) {
            if (this.validateForm()) {
                if (this.formType) {
                    this.addNewPosts(data);
                } else {
                    this.updatePosts(data);
                }
            } else {
                this.globalError = "Vui lòng điền đầy đủ thông tin.";
            }
        }
    },
    components: {
        TextEdit,
        Multiselect
    },
    computed: {
        ...mapGetters('category', ['categoryAll']),
        ...mapGetters('posts', ['posts']),
        category() {
            let dataCategory = [];
            for (const item of this.categoryAll) {
                dataCategory.push({
                    value: {
                        id: item.id,
                        name: item.type_name,
                    }, label: item.type_name
                });
            }
            return dataCategory;
        },
        showData() {
            return this.posts;
        },
        getData() {
            return {
                title: this.title,
                slug: this.slug,
                thumbnail: this.thumbnail,
                category: this.values,
                content: this.editorContent,
                type: this.subContent,
                contentUniversity: this.subContent ? this.contentUniversity: "",
                description: this.description,
                id: this.id
            }
        }
    },
    beforeDestroy() {
        if (this.$refs.editor1 && tinymce.get(this.$refs.editor1.id)) {
            tinymce.remove(this.$refs.editor1);
        }
        if (this.$refs.editor2 && tinymce.get(this.$refs.editor2.id)) {
            tinymce.remove(this.$refs.editor2);
        }
    }

}
</script>

<style scoped>
.custom-img {
    width: 100%;
    height: 200px;
}

.box-img img {
    width: 100%;
    height: 100%;
    object-fit: contain !important;
}

.box-img {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;
    border: 4px dashed #cccc;
    border-radius: 10px;
}

.text-danger {
    color: red;
}
</style>
