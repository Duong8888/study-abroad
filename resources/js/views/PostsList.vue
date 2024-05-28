<template>
    <section class="py-12 py-md-16 py-lg-24 pt-100">
        <div class="container mb-50">
            <div class="mw-6xl mx-auto">
                <h2 class="font-heading mb-6">Blog</h2>
                <p class="fs-5 text-light-dark mb-24">Các bài viết và bản phát hành mới nhất</p>
                <a class="d-block mb-20 p-4 bg-white mb-20 border rounded-3" href="#">
                    <div class="rounded-3">
                        <router-link :to="{name: 'PostsDetail', params: {slug: postsNew?.slug}}">
                            <div class="row">
                                <div class="position-relative col-12 col-md-6 p-0 rounded-3 overflow-hidden">
                                    <img class="img-fluid d-block h-100 w-100" :src="postsNew?.thumbnail"
                                         alt="">
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex flex-col h-100 align-items-center">
                                        <div class="mw-md mx-auto py-8 px-8">
                                            <h4 class="mb-4">{{ postsNew?.title }}</h4>
                                            <p class="text-light-dark mb-10 description">{{ postsNew?.description }}</p>
                                            <div>
                                            <span
                                                class="me-3 small text-light-dark">{{
                                                    formatDateTime(postsNew?.created_at)
                                                }}</span>
                                                <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="2" cy="2" r="2" fill="#B8B8B8"></circle>
                                                </svg>
                                                <span v-for="category in JSON.parse(postsNew?.post_type_id)"
                                                      :key="category"
                                                      class="badge ms-3 small fw-medium text-light-dark border mr-2">{{
                                                        category.name
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </a>
                <h4 class="mb-10">Bài viết mới nhất</h4>
                <ul class="nav mb-5">
                    <li><a data-toggle="tab" href="#home">
                        <button type="button" class="btn btn-outline-success mr-2 mb-2">Tất cả bài viết</button>
                    </a></li>
                    <li v-for="(item,index) in category" :key="item"><a data-toggle="tab" :href="'#menu'+(index+1)">
                        <button type="button" class="btn btn-outline-success mr-2 mb-2">{{ item?.type_name }}</button>
                    </a></li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <div class="row mb-n8">
                            <div class="col-12 col-sm-6 col-lg-4 mb-8" v-for="item in postsList" :key="item">
                                <router-link :to="{name: 'PostsDetail', params: {slug: item?.slug}}">
                                    <div class="card p-3 h-100 overflow-hidden">
                                        <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                            <img class="card-img-top rounded-0" :src="item?.thumbnail"
                                                 alt="...">
                                        </div>
                                        <div class="card-body d-flex flex-column align-items-start mw-xs">
                                            <h6 class="card-title mb-3">{{ item?.title }}</h6>
                                            <p class="card-text small text-light-dark mb-6 description">
                                                {{ item?.description }}</p>
                                            <div class="mt-auto">
                                                <span
                                                    class="me-3 small text-light-dark">{{
                                                        formatDateTime(item?.created_at)
                                                    }}</span>
                                                <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                                </svg>
                                                <span v-for="category in JSON.parse(item?.post_type_id)" :key="category"
                                                      class="badge ms-3 small fw-medium text-light-dark border mr-2">{{
                                                        category.name
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <div class="row mb-n8">
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Make Your Phone Your Best Study Tool</h6>
                                        <p class="card-text small text-light-dark mb-6">How do we make our phone best
                                            study
                                            tool? Read on to find out more.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Tips</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">How to Maintain Good Wellbeing While Studying</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Wellbeing</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Atomic Habits: Tiny Changes, Remarkable Results</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span
                                                class="badge ms-3 text-light-dark fw-medium border">Productivity</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Make Your Phone Your Best Study Tool</h6>
                                        <p class="card-text small text-light-dark mb-6">How do we make our phone best
                                            study
                                            tool? Read on to find out more.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Tips</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">How to Maintain Good Wellbeing While Studying</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Wellbeing</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Atomic Habits: Tiny Changes, Remarkable Results</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span
                                                class="badge ms-3 text-light-dark fw-medium border">Productivity</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <div class="row mb-n8">
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Make Your Phone Your Best Study Tool</h6>
                                        <p class="card-text small text-light-dark mb-6">How do we make our phone best
                                            study
                                            tool? Read on to find out more.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Tips</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">How to Maintain Good Wellbeing While Studying</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Wellbeing</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Atomic Habits: Tiny Changes, Remarkable Results</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span
                                                class="badge ms-3 text-light-dark fw-medium border">Productivity</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Make Your Phone Your Best Study Tool</h6>
                                        <p class="card-text small text-light-dark mb-6">How do we make our phone best
                                            study
                                            tool? Read on to find out more.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Tips</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">How to Maintain Good Wellbeing While Studying</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Wellbeing</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Atomic Habits: Tiny Changes, Remarkable Results</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span
                                                class="badge ms-3 text-light-dark fw-medium border">Productivity</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <div class="row mb-n8">
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Make Your Phone Your Best Study Tool</h6>
                                        <p class="card-text small text-light-dark mb-6">How do we make our phone best
                                            study
                                            tool? Read on to find out more.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Tips</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">How to Maintain Good Wellbeing While Studying</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Wellbeing</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Atomic Habits: Tiny Changes, Remarkable Results</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span
                                                class="badge ms-3 text-light-dark fw-medium border">Productivity</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Make Your Phone Your Best Study Tool</h6>
                                        <p class="card-text small text-light-dark mb-6">How do we make our phone best
                                            study
                                            tool? Read on to find out more.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Tips</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">How to Maintain Good Wellbeing While Studying</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span class="badge ms-3 text-light-dark fw-medium border">Wellbeing</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4 mb-8">
                                <a class="card p-3 h-100 overflow-hidden" href="#">
                                    <div class="position-relative rounded-2 overflow-hidden" style="height: 184px;">
                                        <img class="card-img-top rounded-0" src="@/assets/images/common/banner-3.jpg"
                                             alt="...">
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-start mw-xs">
                                        <h6 class="card-title mb-3">Atomic Habits: Tiny Changes, Remarkable Results</h6>
                                        <p class="card-text small text-light-dark mb-6">Here are some tips on how to
                                            maintain
                                            good wellbeing while studying.</p>
                                        <div class="mt-auto">
                                            <span class="me-3 small text-light-dark">17 Jul 2023</span>
                                            <svg width="4" height="4" viewbox="0 0 4 4" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>
                                            </svg>
                                            <span
                                                class="badge ms-3 text-light-dark fw-medium border">Productivity</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {mapGetters, mapActions} from "vuex";

export default {
    name: "PostsList",
    data() {
        return {
            postsList: [
                {
                    slug: "posts",
                    thumbnail: null,
                    title: null,
                    created_at: null,
                    post_type_id: '[{"id": null, "name": null}]',
                }
            ],
            category: [],
            postsNew: {
                slug: "posts",
                thumbnail: null,
                title: null,
                created_at: null,
                post_type_id: '[{"id": null, "name": null}]',
            },
        }
    },
    methods: {
        ...mapActions('posts', ['fetchPost']),
        ...mapActions('category', ['fetchCategory']),
        async getData() {
            await this.fetchPost();
            await this.fetchCategory();
        },
        formatDateTime(dateTimeStr) {
            const date = new Date(dateTimeStr);
            const hours = date.getUTCHours().toString().padStart(2, '0');
            const minutes = date.getUTCMinutes().toString().padStart(2, '0');
            const day = date.getUTCDate().toString().padStart(2, '0');
            const month = (date.getUTCMonth() + 1).toString().padStart(2, '0');
            const year = date.getUTCFullYear();
            return `${hours}:${minutes} ${day}/${month}/${year}`;
        },
    },
    computed: {
        ...mapGetters('category', ['categoryAll']),
        ...mapGetters('posts', ['postsAll']),
    },
    watch: {
        postsAll: {
            handler(newVal) {
                this.postsList = newVal.slice();
                if (this.postsList.length > 0) {
                    this.postsList.shift();
                    this.postsNew = newVal[0];
                }
            },
            immediate: true
        },
        categoryAll: {
            handler(newVal) {
                this.category = newVal;
            },
            immediate: true
        },
    },
    created() {
        this.getData();
    },
}
</script>

<style scoped>
p, span {
    color: #0b0b0b;
}

.active button {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
}

.card-img-top {
    height: 100%;
    object-fit: cover;
    border-radius: 3px !important;
}

.img-fluid {
    object-fit: cover !important;
    width: 100%;
    height: 200px !important;
    border-radius: 5px;
}

.description {
    font-size: 14px;
    margin: 0;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    white-space: normal;
    text-overflow: ellipsis;
    width: 100%;
}
</style>
