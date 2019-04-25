<template>

    <div>

        <div class="row" v-if="signedIn">
            <div class="col-md-8">
                    <div class="form-group">
                        <label for="body">Body:</label>
                        <textarea id="body"
                                  name="body"
                                  rows="5"
                                  class="form-control"
                                  placeholder="Have something to say?"
                                  v-model="body"
                        ></textarea>
                    </div>

                    <button type="submit"
                            class="btn btn-outline-primary"
                            @click="addReply">Post a reply</button>
            </div>
        </div>

        <div class="col-md-8" v-else>
            <p  class="text-center">Please, <a href="/login"> sign in</a> to participate in this
                discussion
            </p>
        </div>

    </div>

</template>

<script>

    export default{

        data(){
            return {
                body: ''
            }
        },
        computed:{
            signedIn(){
                return window.signedIn;
            }
        },
        methods: {
            addReply(){
                axios.post(window.location.pathname + '/replies', {body: this.body})
                    .then(({data}) => {
                    this.body = '';
                    flash('Your reply has been posted');

                    this.$emit('reply-was-created', data);
                    })
            }
        }
    }

</script>

<style scoped>


</style>