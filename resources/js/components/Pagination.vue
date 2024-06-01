<template>
    <nav aria-label="Page navigation" class="mb-5">
        <ul class="pagination justify-content-center">
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                <button class="page-link rounded-circle" @click="previousPage" :disabled="currentPage === 1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="m12.707 7.707-1.414-1.414L5.586 12l5.707 5.707 1.414-1.414L8.414 12z"></path><path d="M16.293 6.293 10.586 12l5.707 5.707 1.414-1.414L13.414 12l4.293-4.293z"></path></svg>
                </button>
            </li>
            <li
                v-for="page in pages"
                :key="page"
                class="page-item"
                :class="{ active: page === currentPage, disabled: page === '...' }"
            >
                <button
                    class="page-link rounded-circle mx-1"
                    @click="changePage(page)"
                    v-if="page !== '...'"
                >{{ page }}</button>
                <span class="page-link rounded-circle" v-else>...</span>
            </li>
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                <button class="page-link rounded-circle" @click="nextPage" :disabled="currentPage === totalPages">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M10.296 7.71 14.621 12l-4.325 4.29 1.408 1.42L17.461 12l-5.757-5.71z"></path><path d="M6.704 6.29 5.296 7.71 9.621 12l-4.325 4.29 1.408 1.42L12.461 12z"></path></svg>
                </button>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        totalItems: {
            type: Number,
            required: true
        },
        itemsPerPage: {
            type: Number,
            required: true
        },
        currentPage: {
            type: Number,
            required: true
        }
    },
    computed: {
        totalPages() {
            return Math.ceil(this.totalItems / this.itemsPerPage);
        },
        pages() {
            if (this.totalPages <= 7) {
                return Array.from({ length: this.totalPages }, (v, k) => k + 1);
            } else if (this.currentPage <= 4) {
                return [1, 2, 3, 4, 5, '...', this.totalPages];
            } else if (this.currentPage >= this.totalPages - 3) {
                return [1, '...', this.totalPages - 4, this.totalPages - 3, this.totalPages - 2, this.totalPages - 1, this.totalPages];
            } else {
                return [1, '...', this.currentPage - 1, this.currentPage, this.currentPage + 1, '...', this.totalPages];
            }
        }
    },
    methods: {
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.$emit('update:currentPage', this.currentPage + 1);
                this.scrollToHome();
            }
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.$emit('update:currentPage', this.currentPage - 1);
                this.scrollToHome();
            }
        },
        changePage(page) {
            if (page !== '...') {
                this.$emit('update:currentPage', page);
                this.scrollToHome();
            }
        },
        scrollToHome() {
            const element = document.getElementById('main-home');
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }
}
</script>

<style scoped>
.page-link {
    border-radius: 50% !important;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-item.active .page-link {
    background-color: #be1510;
    border-color: #be1510;
    color: white;
}

.page-link {
    color: #be1510;
}

.page-link:hover {
    background-color: #be1510;
    color: white;
}
.page-link:focus {
    box-shadow: 0 0 0 0.25rem rgba(190, 21, 16, 0.5);
    border-color: #be1510;
}
</style>
