<template>

    <li class="comment-form">

        <form @submit.prevent="onAddComment">

            <div class="panel panel-default share clearfix-xs">

                <div class="panel-body">

                    <input name="category_id" value="1" type="hidden">
                    <input name="user_id" value="1" type="hidden">
                    <textarea name="content" class="form-control share-text" rows="3" v-model="content"
                              @keyup="onTextKeyPress"
                              @keyup.enter="onAddComment"
                              placeholder="Add comment..."></textarea>
                </div>

                <div class="panel-footer share-buttons">
                    <a href="#"><i class="fa fa-map-marker"></i></a>
                    <a href="#"><i class="fa fa-photo"></i></a>
                    <a href="#"><i class="fa fa-video-camera"></i></a>
                    <a 
                        @click="addCommentClick" 
                        title="Close comment box">
                        <i class="fa fa-close"></i>
                    </a>
                    <button type="submit"
                            :disabled="textLength < 1 ? true : false"
                            class="btn btn-primary btn-xs pull-right">
                            <span v-if="addLoading"><i class='fa fa-spinner fa-spin'></i></span> &nbsp;
                            Save Comment
                    </button>

                </div>

            </div>

        </form>

    </li>

</template>

<script>

    export default {

        props: ['post'],

        data(){
            return {
                content: '',
                textLength:'',
                typing: false,
                addLoading: false
            }
        },

        methods: {

            onAddComment() {
                
                this.addLoading = true;
                let post_id = this.post.id;

                if (post_id !== null) {
                    
                    let postData = {
                        'content': this.content,
                        'post_id': post_id
                    }

                    //post form data
                    this.$store.dispatch('addNewComment', postData)
                        .then(response => {
                            this.addLoading = false;
                            this.content = null;
                            this.textLength = 0;
                            this.$emit('addCommentChild', false);
                        })
                        .catch(error => console.log(error));
                    
                }

            },

            addCommentClick(){
                this.$emit("clickCommentAddComment", true);
            },

            onTextKeyPress(){

                this.textLength = this.content.length

                //if text is typed in
                if (this.content.length > 0){
                    typing: true;
                } else {
                    typing: false;
                }

            }

        }

    }

</script>

<style>


</style>
