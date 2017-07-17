<template>

    <div>

        <div class="item">
            <div class="timeline-block">

                <form @submit.prevent="onSubmitted">

                    <div class="panel panel-default share clearfix-xs">
                        <div class="panel-heading panel-heading-gray title">
                            Create a New Post
                        </div>
                        <div class="panel-body">
                            <!--<p class="text-danger" v-if="errors.has('text')">{{ errors.first('text') }}</p>-->
                            <input name="category_id" value="1" type="hidden">
                            <input name="user_id" value="1" type="hidden">
                            <textarea name="content" class="form-control share-text" rows="3" v-model="content"
                                      @keyup="onTextKeyPress"
                                      placeholder="Type text here..."></textarea>
                        </div>
                        <div class="panel-footer share-buttons">
                            <a href="#"><i class="fa fa-map-marker"></i></a>
                            <a href="#"><i class="fa fa-photo"></i></a>
                            <a href="#"><i class="fa fa-video-camera"></i></a>
                            <button type="submit"
                                    :disabled="textLength < 1 ? true : false"
                                    class="btn btn-primary btn-xs pull-right">
                                    <span v-if="addLoading"><i class='fa fa-spinner fa-spin'></i></span> &nbsp;
                                    Add Post
                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>


<script>

    import { mapState } from 'vuex';

    export default {

        data(){
            return {
                content: '',
                textLength:'',
                addLoading: false
            }
        },
        
        methods: {

            onTextKeyPress(){
                this.textLength = this.content.length
            },

            onSubmitted() {
                
                this.addLoading = true;

                if (this.content !== null) {
                    
                    let postData = {
                        'content': this.content,
                        'wall_id': this.currentUserStore.currentUser.id
                    }

                    //post form data
                    this.$store.dispatch('addNewPost', postData)
                        .then(response => {
                            this.addLoading = false;
                            this.content = null;
                            this.textLength = 0;
                        })
                        .catch(error => console.log(error));
                    
                }

            }

        },

        computed: {
            
            ...mapState({
                currentUserStore: state => state.currentUser
            })

        }

    }

</script>


<style>


</style>
