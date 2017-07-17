<template>

    <div>

        <div class="item">
            <div class="timeline-block">
                <div class="panel panel-default">

                    <!-- {{ postcomments }} -->
                    <app-post-text :post="post" 
                        :postLikes="postLikes" 
                        :comments="postcomments"  
                        @clickAddComment="addCommentBool = !addCommentBool">
                    </app-post-text>

                    <ul class="comments">

                        <!-- add comment form-->

                        <transition name="fade">

                            <div v-if="addCommentBool">

                                <app-post-comment-form :post="post" 
                                    @clickCommentAddComment="addCommentBool = !addCommentBool" 
                                    @addCommentChild="addCommentChild">
                                </app-post-comment-form>

                            </div>

                        </transition>

                        <!-- end add comment form-->


                        <!-- loop through comments-->

                        <app-post-comments :comments="postcomments" :post="post"></app-post-comments>

                        <!-- end loop through comments-->

                    </ul>
                </div>
            </div>
        </div>

    </div>

</template>


<!-- <ul id="datalist">
    <li>dataset1</li>
    <li>dataset1</li>
    <li>dataset2</li>
    <li>dataset2</li>
    <li>dataset3</li>
    <li>dataset3</li>
    <li>dataset4</li>
    <li>dataset4</li>
    <li>dataset5</li>
    <li>dataset5</li>
</ul> <span>readmore</span> -->

<script>
    /*$('span').click(function () {
        $('#datalist li:hidden').slice(0, 2).show();
        if ($('#datalist li').length == $('#datalist li:visible').length) {
            $('span ').hide();
        }
    });*/
</script>

<script>

    
    import PostText from './PostText.vue'
    import PostComments from '../comment/Comments.vue'
    import CommentForm from '../comment/CommentAdd.vue'

    export default {

        props: ['post'],

        components: {
            appPostText: PostText,
            appPostCommentForm: CommentForm,
            appPostComments: PostComments
        },
        
        data(){
            return {
                emoji: '',
                visible: false,
                addCommentBool: false,
                postcomments: [],
                postLikes: []
            }

        },

        methods: {
            
            getPostComments() {
                this.$store.dispatch('getPostComments', this.post)
                .then(response => {
                    //console.log(response)
                    this.postcomments = response
                })
            },

            getPostLikes() {
                this.$store.dispatch('getPostLikes', this.post)
                .then(response => {
                    //console.log(response)
                    this.postLikes = response
                })
            },

            addCommentChild(){
                //hide comment box
                this.addCommentBool = false;
            }

        },

        mounted(){

            this.getPostComments(),
            this.getPostLikes()

        },

        computed(){

            this.getPostComments(),
            this.getPostLikes()

        }


    }

</script>

<style>
    
    /*ul li:nth-child(n+3) {
        display:none;
    }
    ul li {
        border: 1px solid #aaa;
    }
    span {
        cursor: pointer;
        color: #f00;
    }*/

    .comments{background:#f7f7f7;}
    ul.emoji-list * {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    ul.emoji-list li {
        font-size: 36px;
        float: left;
        display: inline-block;
        padding: 2px;
        margin: 4px;
    }
    img.emoji {
        cursor: pointer;
        height: 1em;
        width: 1em;
        margin: 0 .05em 0 .1em;
        vertical-align: -0.1em;
    }

    /*transitions*/
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-to {
        opacity: 0
    }
    /*transitions*/

</style>
