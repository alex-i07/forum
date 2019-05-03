<script>

    import RepliesComponent from './RepliesComponent.vue'

    import SubscribeButtonComponent from './SubscribeButtonComponent.vue'

    export default{
        components: {RepliesComponent, SubscribeButtonComponent},

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
