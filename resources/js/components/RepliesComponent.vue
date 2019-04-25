<template>

    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply-component :reply="reply" @ReplyHasBeenDeleted="remove(index)"></reply-component>
        </div>

        <paginator-component :dataSet="dataSet" @page-changed="fetch"></paginator-component>

        <create-reply-component @reply-was-created="addReply"></create-reply-component>
    </div>

</template>

<script>

    import ReplyComponent from './ReplyComponent.vue';

    import CreateReplyComponent from './CreateReplyComponent.vue';

    import collection from '../mixins/collection';

    export default{

        components: {ReplyComponent, CreateReplyComponent},

        mixins: [collection],

        data(){
            return {
                dataSet: false
            }
        },
        created(){
            this.fetch();
        },

        methods: {

            fetch(page){
                axios.get(this.url(page))
                    .then(this.refresh);
            },

            url(page){

                if (!page){
                    let query = window.location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }

                return `${window.location.pathname}/replies?page=${page}`;
            },

            refresh({data}){
                this.dataSet = data;
                this.items = data.data;
            }
        }
    }

</script>

<style scoped>


</style>