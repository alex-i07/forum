<template>

    <div>
        <div v-for="(reply, index) in replies" :key="reply.id">
            <reply-component :reply="reply" @ReplyHasBeenDeleted="remove(index)"></reply-component>
        </div>

        <create-reply-component @reply-was-created="addReply" :endpoint="endpoint"></create-reply-component>
    </div>

</template>

<script>

    import ReplyComponent from './ReplyComponent.vue'

    import CreateReplyComponent from './CreateReplyComponent.vue'

    export default{
        props: ['data'],

        components: {ReplyComponent, CreateReplyComponent},

        data(){
            return {
                replies: this.data,
                endpoint: window.location.pathname + '/replies'
            }
        },

        methods: {
            remove(index){
                this.replies.splice(index, 1);

                this.$emit('removed');

                flash('Your reply has been successfully deleted!');
            },

            addReply(reply){
                this.replies.push(reply);
                this.$emit('added');
            }
        }
    }

</script>

<style scoped>


</style>