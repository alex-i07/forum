export default{

    data(){
        return {
            replies: []
        }
    },

    methods: {
        addReply(item){
            this.replies.push(item);
            this.$emit('added');
        },
        remove(index){
            this.replies.splice(index, 1);

            this.$emit('removed');
        }

    }
}