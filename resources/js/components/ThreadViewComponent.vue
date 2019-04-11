<script>

    import RepliesComponent from './RepliesComponent.vue'
    export default{
        components: {RepliesComponent},

        props: ['initialRepliesCount'],

        data(){
            return {
                repliesCount: this.initialRepliesCount
            }
        },

        mounted(){
            this.$on('removed', () => this.repliesCount--);
        }
    }

</script>
