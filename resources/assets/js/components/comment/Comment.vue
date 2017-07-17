<template>

    <div>

        <li 
            class="media single-comment" 
            @mouseover="onCommentHover" 
            @mouseout="onCommentHoverOut">

            <div class="media-left">
                <a href="" v-if="comment.creator">
                    <img :src="comment.creator.img_thumb" class="media-object" height="50">
                </a>
            </div>

            <div 
                class="media-body">

                <span 
                    v-if="isAuthUser(comment.user_id)">
                    
                    <div 
                        class="pull-right dropdown" 
                        data-show-hover="li" 
                        v-if="showCommentActions">

                        <a  @click="comments_menu_drop = !comments_menu_drop"
                            v-on-clickaway="away"
                            data-toggle="dropdown" class="toggle-button">
                            <i class="fa fa-pencil"></i>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a @click="onCommentEditClick">Edit</a></li>
                            <li><a @click="onCommentDeleteClick">Delete</a></li>
                        </ul>

                    </div>

                </span>
                                
                <a :href="thisCommentUserLink" class="comment-author pull-left">
                    {{ comment.user.first_name }}
                </a>

                <br>

                <span>{{ editCommentValue }}</span>
                <br>

                <div v-if="editing">
                    <textarea  v-model="editCommentValue" class="form-control"
                              placeholder="Enter comment"></textarea>
                    <a @click="onUpdate">Save</a> &nbsp;
                    <span v-if="saveLoading"><i class='fa fa-spinner fa-spin'></i></span> &nbsp;
                    <a @click="onCancel">Cancel</a>
                </div>

                <!-- Show formatted date, if more 1 week ago -->
                <div class="comment-date" v-if="more_one_wk">on {{ comment.created_at | createdDateWeeks }}</div>

                <!-- Show formatted date, if less 1 week ago -->
                <div class="comment-date" v-if="less_one_wk">on {{ comment.created_at | createdDateWeek }}</div>

                <!-- Show formatted date, if less 1 day ago -->
                <div class="comment-date" v-if="less_one_day">

                    <span v-if="todayDate"> 
                        Today at {{ comment.created_at | createdDate }}
                    </span>
                    <span v-if="!todayDate"> 
                        at {{ comment.created_at | createdDate2 }}
                    </span>

                </div>

                <!-- Auto-update time every 60 seconds, if less 4 hrs ago -->
                <div 
                    class="comment-date" 
                    v-if="less_four_hr">
                    <timeago 
                        :since="comment.created_at" 
                        :auto-update="60">
                    </timeago>
                </div>


            </div>

        </li>


        <!-- Modal -->
        <div id="deleteModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button 
                            type="button" 
                            class="close" 
                            data-dismiss="modal" 
                            aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title">Delete Comment</h4>
                    </div>

                    <div class="modal-body">

                        <p>Are you sure you want to delete this comment?</p>

                    </div>

                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-danger" 
                            @click="onDeleteComment">
                            <span v-if="deleteLoading">
                                <i class='fa fa-spinner fa-spin'></i>
                            </span>
                            Delete
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>


    </div>


</template>

<script>

    import { mapState } from 'vuex'
    import VueClickaway from 'vue-clickaway'

    export default {

        mixins: [ VueClickaway.mixin ],
        props: ['comment', 'post'],
        data(){
            return {
                editCommentValue: this.comment.content,
                editing: false,
                saveLoading: false,
                todayDate: false,
                deleteLoading: false,
                emoji: '',
                less_four_hr: false,
                less_one_day: false,
                less_one_wk: false,
                more_one_wk: false,
                showCommentActions: true,
                comments_menu_drop: false
            }
        },

        computed: {
            
            ...mapState({
                authUserStore: state => state.authUser
            }),

            thisCommentUserLink() {
                return '/profile/' + this.comment.user_id
            }

        },
        methods: {
            
            //check if this is the logged in user or not
            isAuthUser(user_id){
                return user_id === this.authUserStore.authUser.id
            },

            onCommentHover: _.throttle(() => {
                this.showCommentActions = true //fire after half seconds
                //console.log("true");
                //this.showCommentActions = !this.showCommentActions
            }, 500),

            onCommentHoverOut: _.throttle(() => {
                this.showCommentActions = false //fire after half seconds
                //console.log("false");
                //this.showCommentActions = !this.showCommentActions
            }, 500),

            onCommentsMenuClick() {
                this.comments_menu_drop = true
            },

            onCommentEditClick(){
                this.editCommentValue = this.comment.content
                this.editing = true
            },

            onCommentDeleteClick(){

                $('#deleteModal').modal('show')

            },

            onDeleteComment() {
                
                this.deleteLoading = true

                if (this.comment !== null) {
                    
                    let postData = {
                        'id': this.comment.id
                    }
                    //post form data
                    this.$store.dispatch('deleteComment', postData)
                        .then(response => {

                            this.loading = false
                            this.deleteLoading = false

                            //close modal
                            $('#deleteModal').modal('toggle') //or  $('#IDModal').modal('hide');
                            return false;

                        })
                        .catch(error => console.log(error))

                }

            },

            onCancel(){
                this.editCommentValue = this.comment.content
                this.saveLoading = false
                this.editing = false
            },

            away: function() {
                this.comments_menu_drop = false
                console.log('clicked away')
            },

            onUpdate() {
                
                if (this.comment.content !== null) {
                    
                    this.saveLoading = true

                    let postData = {
                        'content': this.editCommentValue,
                        'id': this.comment.id
                    }

                    //post form data
                    this.$store.dispatch('updatePostComment', postData)
                        .then(response => {
                            this.saveLoading = false
                            this.editing = false                         
                        })
                        .catch(error => console.log(error))
                    
                }

            }

        },

        created(){

            //this.emoji = twemoji.parse('\ud83d\ude07\ud83d\ude09');
            //this.emoji = twemoji.parse(document.body);

            //this.emoji = twemoji.convert.toCodePoint('\ud83c\udde8\ud83c\uddf3');

            this.todayDate = false
            this.less_four_hr = false
            this.less_one_day = false
            this.less_one_wk = false
            this.more_one_wk = false

            let created_at = this.comment.created_at
            let todayDateValue = new Date(Date.now())

            let content = this.comment.content

            let ONE_HOUR = 60 * 60 * 1000 /* ms */
            let FOUR_HOUR = ONE_HOUR * 4
            let ONE_DAY = ONE_HOUR * 24
            let ONE_WEEK = ONE_DAY * 7

            let created_date_obj = new Date(created_at)

            let timeDifference = Math.floor(todayDateValue - created_date_obj.getTime())

            //check if date is today
            var isToday = (created_date_obj.toDateString() === todayDateValue.toDateString())

            if (isToday){ this.todayDate = true }

            //check if created time is less than an hr
            if (timeDifference < FOUR_HOUR){
                this.less_four_hr = true
            } else if ((timeDifference > FOUR_HOUR) && (timeDifference < ONE_DAY)){
                this.less_one_day = true
            } else if ((timeDifference > ONE_DAY) && (timeDifference < ONE_WEEK)){
                this.less_one_wk = true
            } else if (timeDifference > ONE_WEEK){
                this.more_one_wk = true
            }

        }

    }

</script>

<style>

    li.single-comment{margin-bottom: 5px;}

</style>
