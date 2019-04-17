<template>

    <div>
        <div v-for="(reply, index) in replies" :key="reply.id">
            <reply-component :reply="reply" @ReplyHasBeenDeleted="remove(index)"></reply-component>
        </div>

        <create-reply-component @reply-was-created="addReply" :endpoint="endpoint"></create-reply-component>
    </div>

</template>

<script>

    import ReplyComponent from './ReplyComponent.vue';

    import CreateReplyComponent from './CreateReplyComponent.vue';

    import collection from '../mixins/repliesCollection';

    export default{

        components: {ReplyComponent, CreateReplyComponent},

        mixins: [collection],

        data(){
            return {
                dataSet: false,
                endpoint: window.location.pathname + '/replies'
            }
        },
        created(){
            this.fetch();
        },

        methods: {

            fetch(){
                axios.get(this.url())
                    .then(this.refresh);
            },

            url(){
                return `${window.location.pathname}/replies`;
            },

            refresh({data}){
                this.dataSet = data;
                this.replies = data.data;
            }
        }
    }

</script>

<style scoped>


</style>