<template>

    <div>
        <button type="submit" :class="classes" @click="toogle">
            <span><i class="fa fa-thumbs-up"></i></span>
            <span v-text="favoritesCount"></span>
        </button>

    </div>

</template>

<script>

    export default{

        props: ['reply'],

        data(){
            return {
                favoritesCount: this.reply.favorites_count,
                isFavorited: this.reply.is_favorited
            }
        },
        computed: {
            classes(){
                return ['btn', this.isFavorited ? 'btn-outline-success' : 'btn-outline-info']
            },
            endpoint(){
                return '/replies/' + this.reply.id + '/favorites';
            }
        },
        methods: {
            toogle(){
                 this.isFavorited ? this.unfavorite() : this.favorite();
            },
            favorite(){
                axios.post(this.endpoint);

                this.isFavorited = true;

                this.favoritesCount++;
            },
            unfavorite(){
                axios.delete(this.endpoint);

                this.isFavorited = false;

                this.favoritesCount--;
            }
        }
    }

</script>