<template>

    <div>
        <div v-for="(reply, index) in replies">
            <reply-component :reply="reply" @ReplyHasBeenDeleted="remove(index)"></reply-component>
        </div>
    </div>

</template>

<script>

    import ReplyComponent from './ReplyComponent.vue'

    export default{
        props: ['data'],

        components: {ReplyComponent},

        data(){
            return {
                replies: this.data
            }
        },

        methods: {
            remove(index){
                this.replies.splice(index, 1);

                this.$emit('removed');

                flash('Your reply has been successfully deleted!');
            }
        }
    }

</script>

<style scoped>


</style>