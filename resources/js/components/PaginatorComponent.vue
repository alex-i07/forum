<template>

    <div>

        <ul class="pagination justify-content-end" v-if="shouldPaginate">
            <li class="page-item" v-bind:class="{'disabled': !(!! prevUrl)}">
                <a class="page-link" href="#" tabindex="-1" rel="previous" @click.prevent="page--">&laquo; Previous</a>
            </li>
            <li class="page-item" v-bind:class="{'disabled': !(!! nextUrl)}">
                <a class="page-link" href="#" rel="next" @click.prevent="page++">Next &raquo;</a>
            </li>
        </ul>

    </div>

</template>

<script>

    export default{

        props: ['dataSet'],

        data(){
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false,
            }
        },

        computed: {
            shouldPaginate(){
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

        watch:{
            dataSet(){
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

            page(){
                this.broadcast().updateUrl();
            }
        },

        methods: {
            broadcast(){
                this.$emit('page-changed', this.page);
            },
            updateUrl(){
                window.history.pushState(null, null, '?page=' + this.page);
            }
        }
    }

</script>

<style scoped>


</style>