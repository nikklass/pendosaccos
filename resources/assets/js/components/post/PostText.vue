<template>

    <div>

        <div class="panel-heading">

            <div class="media">
                
                <div class="media-left">
                    <a href="">
                        <img src="./../../assets/images/people/guy-3.jpg" class="media-object" height="50">
                    </a>
                </div>

                <div class="media-body">

                    <div class="pull-right dropdown" data-show-hover="li">

                        <a  @click="post_menu_drop = !post_menu_drop"
                            data-toggle="dropdown" class="toggle-button">
                            <i class="fa fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a @click="onPostEditClick">Edit</a></li>
                            <li><a @click="onPostDeleteClick">Delete</a></li>
                        </ul>

                    </div>

                    <a href="#" class="pull-right text-muted">
                        <i class="icon-reply-all-fill fa fa-2x "></i>
                    </a>
                 
                    <a :href="thisPostUserLink">
                        {{ post.user.first_name }}
                    </a>

                    <!--{{emoji}}-->

                    <!-- Show formatted date, if more 1 week ago -->
                    <span v-if="more_one_wk">on {{ post.created_at | createdDateWeeks }}</span>

                    <!-- Show formatted date, if less 1 week ago -->
                    <span v-if="less_one_wk">on {{ post.created_at | createdDateWeek }}</span>

                    <!-- Show formatted date, if less 1 day ago -->
                    <span v-if="less_one_day">

                        <span v-if="!todayDate"> at {{ post.created_at | createdDate2 }}</span>
                        <span v-if="todayDate"> Today at {{ post.created_at | createdDate }}</span>

                    </span>

                    <!-- Auto-update time every 60 seconds, if less 4 hrs ago -->
                    <span v-if="less_four_hr"><timeago :since="post.created_at" :auto-update="60"></timeago></span>

                </div>


            </div>

        </div>


        <div class="panel-body" v-if="post.content">
            <p>{{ post.content }}</p>
            <div class="timeline-added-images" v-if="post.total_photos">
                <img :src="photo.user_image" width="80" :alt="photo.caption" v-for="photo in post.photos"/>
            </div>
        </div>


        <div v-if="post.color_class" class="panel-body no-padding">

            <div :class="post.color_class">

                <div class="colored-status center-vertical">

                    <p class="text-center">
                        {{ post.content }}
                    </p>

                </div>

            </div>

        </div>


        <div class="view-all-comments">

            <span v-if="comments.length">

                <a href="#">
                    
                    <i class="fa fa-comments-o"></i> 

                    <span>

                        {{ comments.length }} 

                        <span v-if="comments.length > 1">
                            comments
                        </span>

                        <span v-if="comments.length === 1">
                            comment
                        </span>
                    
                    </span>

                </a>

                &nbsp;&nbsp;

            </span>

            <span>
                <!-- <pre>{{ postLikes }}</pre> -->
                <!-- <pre>{{ comments }}</pre>  -->
                <span v-if="postLikes.length">
                    
                    <a href="#"> 
                        
                        <i class="fa fa-heart icon"></i> 
                        
                        <span v-if="isLiked">
                            You&nbsp;
                            <span v-if="postLikes.length === 2"> 
                                and {{ postLikes.length - 1 }} person&nbsp;
                            </span>
                            <span v-if="postLikes.length > 2"> 
                                and {{ postLikes.length - 1 }} people&nbsp;
                            </span>
                            like this
                        </span> 

                        <span v-if="!isLiked">
                            <span v-if="postLikes.length === 1"> 
                                1 person likes this
                            </span>
                            <span v-if="postLikes.length > 1"> 
                                {{ postLikes.length }} people like this
                            </span>
                        </span> 

                    </a>

                    &nbsp;&nbsp;
                </span>

                <!-- <span v-if="comments.length">
                    <a href="#">
                        <i class="fa fa-comments-o"></i> View all
                    </a>
                    &nbsp;&nbsp;
                </span> -->

            </span>


            <span v-if="!comments.length">
                <a @click="addCommentClick">
                    <i class="fa fa-comments-o"></i>  Be the first to comment &nbsp;&nbsp;
                </a>
            </span>


            <span v-if="comments.length">
                <a @click="addCommentClick">
                    <i class="fa fa-comment icon"></i> Add Comment
                </a>
                &nbsp;&nbsp;
            </span>


            <span v-if="!addLoading">

                <a v-if="isLiked" @click.prevent="postUnlikeClick(post)" title="Unlike Post">
                    <i  class="fa fa-heart icon filled"> <span> Unlike</span></i>
                </a>
                <a v-else @click.prevent="postLikeClick(post)" title="Like Post">
                    <i  class="fa fa-heart-o icon"> <span> Like</span></i>
                </a> 

            </span>

            &nbsp;

            <span v-if="addLoading"><i class='fa fa-spinner fa-spin'></i></span>

        </div>

    </div>

</template>

<script>

    import { mapState } from 'vuex';

    export default {
        
        props: ['post', 'postLikes', 'comments'],

        data(){
            return {
                emoji: '',
                visible: false,
                todayDate: false,
                addCommentBool: false,
                post_menu_drop: false,
                less_four_hr: false,
                less_one_day: false,
                less_one_wk: false,
                more_one_wk: false,
                addLoading: false,
                //comments: [],
                isLiked: false

            }
        },

        methods: {

            postLikeClick() {
                
                this.addLoading = true;
                    
                let postData = {
                    'post_id': this.post.id
                }

                //post form data
                this.$store.dispatch('addNewLike', postData)
                    .then(response => {
                        this.addLoading = false;
                        this.isLiked = true;
                        this.postLikes.length = this.postLikes.length + 1
                    })
                    .catch(error => console.log(error));
                    
            },

            postUnlikeClick() {
                
                this.addLoading = true;
                
                let postData = {
                    'id': this.post.id
                }

                //post form data
                this.$store.dispatch('deleteLike', postData)
                    .then(response => {
                        this.addLoading = false;
                        this.isLiked = false;
                        this.postLikes.length = this.postLikes.length - 1
                    })
                    .catch(error => console.log(error));
                    
            },

            onPostEditClick(){

            },

            onPostDeleteClick(){

            },

            addCommentClick(){
                this.$emit("clickAddComment", true);
            }

            

        },

        mounted() {

            this.isLiked = this.isPostUserLike ? true : false;

        },

        computed: {
            
            thisPostUserLink() {
                return '/profile/' + this.post.user_id
            },

            isPostUserLike() {
                return this.post.liked_by_auth_user 
            }

        },

        created(){

            //this.emoji = twemoji.parse('\ud83d\ude07\ud83d\ude09');
            //this.emoji = twemoji.parse(document.body);

            //this.emoji = twemoji.convert.toCodePoint('\ud83c\udde8\ud83c\uddf3');

            //get time differences in created date
            let created_at = this.post.created_at;

            let todayDateValue = new Date(Date.now());

            let content = this.post.content;

            let ONE_HOUR = 60 * 60 * 1000; /* ms */
            let FOUR_HOUR = ONE_HOUR * 4;
            let ONE_DAY = ONE_HOUR * 24;
            let ONE_WEEK = ONE_DAY * 7;

            let created_date_obj = new Date(created_at);

            let timeDifference = Math.floor(todayDateValue- created_date_obj.getTime());

            //check if date is today
            var isToday = (created_date_obj.toDateString() === todayDateValue.toDateString());

            if (isToday){ this.todayDate = true; }

            //check if created time is less than an hr
            if (timeDifference < FOUR_HOUR){
                this.less_four_hr = true;
            } else if ((timeDifference > FOUR_HOUR) && (timeDifference < ONE_DAY)){
                this.less_one_day = true;
            } else if ((timeDifference > ONE_DAY) && (timeDifference < ONE_WEEK)){
                this.less_one_wk = true;
            } else if (timeDifference > ONE_WEEK) {
                this.more_one_wk = true;
            }

        }

    }

</script>

<style>
    i.filled{color:#e74c3c;}
    i.fa span{font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;}

</style>
