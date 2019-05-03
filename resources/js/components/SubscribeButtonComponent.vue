<template>

    <button class="btn" :class="classes" @click="subscribe">Subscribe</button>

</template>

<script>

    export default{

        props: ['active'],

        data(){
            return {
                isSubscribedTo: this.active
            }
        },

        computed:{
            classes(){
                return ['btn', this.isSubscribedTo ? 'btn-primary' : 'btn-outline-info'];
            }
        },

        methods: {
            subscribe(){

                axios[(this.isSubscribedTo ? 'delete' : 'post')](window.location.pathname + '/subscriptions')
                    .then((response)=>{
                        flash('Subscribed!');
                        this.isSubscribedTo = !this.isSubscribedTo;
                    })
                .catch ((error)=>{
                    flash('Unsubscribed!');
                });
            }
        }
    }

</script>