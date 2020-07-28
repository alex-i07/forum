<template>
    <div>
        <div :id="'reply-' + id" class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a :href="'profile' + reply.owner.name" v-text="reply.owner.name"></a>&nbsp;
                    said <span v-text="ago"></span>...
                </h5>

                <favorite-component v-if="signedIn" :reply="reply"></favorite-component>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                        <button type="button" @click="update" class="btn btn-primary btn-sm">Updade</button>
                        <button type="button" @click="editing=false" class="btn btn-link btn-sm">Cancel</button>
                    </div>
                </div>
                <div v-else v-text="body">
                </div>
            </div>

            <div class="card-footer level mr-1" v-if="canUpdate">
                <button type="button" @click="editing=true" class="btn btn-warning btn-sm">Edit</button>

                <button type="button" @click="destroy" class="btn btn-danger btn-sm">Delete</button>

            </div>
        </div>
    </div>
</template>

<script>

    import FavoriteComponent from './FavoriteComponent.vue';
    import moment from 'moment';

    export default{
        props: ['reply'],

        components: {FavoriteComponent},

        data(){
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body
            }
        },
        computed: {
            signedIn() {
                return window.signedIn;
            },
            canUpdate() {
                return this.authorize(user => this.reply.user_id == window.user_id);
            },
            ago(){
                return moment(this.reply.created_at).fromNow();
            }
        },
        methods: {
            update(){
                axios.patch('/replies/' + this.reply.id, {
                    body: this.body
                })
                .catch(error => {
                    flash(error.response.data, 'danger');
                });

                this.editing = false;

                flash('Updated!');
            },
            destroy(){
                axios.delete('/replies/' + this.reply.id);

                this.$emit('ReplyHasBeenDeleted', this.reply.id);

//                $(this.$el).fadeOut(300, () => {
//                    flash('Your reply has been successfully deleted!');
//                });
            }
        }
    }

</script>