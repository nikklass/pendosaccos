<template>

    <div>
        
        <div class="timeline row">

            <!-- LEFT INNER SIDEBAR -->

            <div class="col-xs-12 col-md-6 col-lg-8">

                <h1>Photos - {{ currentUserStore.currentUser.first_name }}</h1>

                <!-- CREATE NEW POST HERE -->
                <!-- <app-new-post-form></app-new-post-form> -->
                <!-- END CREATE NEW POST HERE -->

                <!-- LOAD POSTS HERE -->
                <!-- <app-posts></app-posts> -->
                <!-- END LOAD POSTS HERE -->

                <div class="item">
                    <div class="timeline-block">
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="">
                                            <img src="../../assets/images/people/guy-2.jpg" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <a href="#" class="pull-right text-muted"><i class="icon-reply-all-fill fa fa-2x "></i></a>

                                        <a href="">Jonathan</a>

                                        <span>on 15th January, 2014</span>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                Kitu Gani
                            </div>
                            <!-- 4:3 aspect ratio -->
                            <div class="embed-responsive embed-responsive-4by3">
                                <iframe  class="embed-responsive-item" src="https://www.youtube.com/embed/MF_ilPWEkws" frameborder="0"></iframe>
                            </div>

                            <div class="view-all-comments"><i class="fa fa-comments-o"></i> Be the first to comment</div>
                            <ul class="comments">
                                <li class="comment-form">
                                    <div class="input-group">

                                        <input type="text" class="form-control" />

                                        <span class="input-group-btn">
                                           <a href="" class="btn btn-default"><i class="fa fa-photo"></i></a>
                                        </span>

                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="item">
                    <div class="timeline-block">
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="">
                                            <img src="../../assets/images/people/woman-1.jpg" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <a href="#" class="pull-right text-muted"><i class="icon-reply-all-fill fa fa-2x "></i></a>

                                        <a href="">Michelle</a>

                                        <span>on 15th January, 2014</span>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body text-muted">
                                <i class="fa fa-map-marker"></i> Was in <a href="#">Brooklyn, New York</a>
                            </div>

                            <div class="relative height-300">
                                <div data-toggle="google-maps" class="maps-google-fs" data-center="40.776928,-73.910330" data-zoom="12" data-style="paper"></div>
                            </div>

                            <div class="view-all-comments">
                                <a href="#">
                                    <i class="fa fa-comments-o"></i> View all
                                </a>
                                <span>10 comments</span>

                            </div>
                            <ul class="comments">
                                <li class="media">
                                    <div class="media-left">
                                        <a href="">
                                            <img src="../../assets/images/people/guy-2.jpg" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="pull-right dropdown" data-show-hover="li">
                                            <a href="#" data-toggle="dropdown" class="toggle-button">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Edit</a></li>
                                                <li><a href="#">Delete</a></li>
                                            </ul>
                                        </div>
                                        <a href="" class="comment-author pull-left">Bill D.</a>
                                        <span>Hi Mary, Nice Party</span>
                                        <div class="comment-date">21st September</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-left">
                                        <a href="">
                                            <img src="../../assets/images/people/woman-3.jpg" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="pull-right dropdown" data-show-hover="li">
                                            <a href="#" data-toggle="dropdown" class="toggle-button">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Edit</a></li>
                                                <li><a href="#">Delete</a></li>
                                            </ul>
                                        </div>
                                        <a href="" class="comment-author pull-left">Mary</a>
                                        <span>Thanks Bill</span>
                                        <div class="comment-date">2 days</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-left">
                                        <a href="">
                                            <img src="../../assets/images/people/guy-2.jpg" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="pull-right dropdown" data-show-hover="li">
                                            <a href="#" data-toggle="dropdown" class="toggle-button">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Edit</a></li>
                                                <li><a href="#">Delete</a></li>
                                            </ul>
                                        </div>
                                        <a href="" class="comment-author pull-left">Bill D.</a>
                                        <span>What time did it finish?</span>
                                        <div class="comment-date">14 min</div>
                                    </div>
                                </li>
                                <li class="comment-form">
                                    <div class="input-group">

                              <span class="input-group-btn">
                       <a href="" class="btn btn-default"><i class="fa fa-photo"></i></a>
                    </span>

                                        <input type="text" class="form-control" />

                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="timeline-block">
                        <div class="panel panel-default">
                            <div class="profile-block">
                                <div class="cover overlay cover-image-full">
                                    <img src="../../assets/images/people/place1-full.jpg" alt="cover">
                                    <div class="overlay overlay-full overlay-bg-black">
                                        <div class="v-top v-spacing-2">
                                            <a href="#" class="icon pull-right">
                                                <i class="fa fa-comment"></i>
                                            </a>
                                            <div class="text-headline text-overlay">Adrian Demian</div>
                                            <p class="text-overlay">User Interface Designer</p>
                                        </div>
                                        <div class="v-bottom">
                                            <a href="#">
                                                <img src="../../assets/images/people/guy-2.jpg" alt="people" class="img-circle avatar" />
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-icons">
                                    <span><i class="fa fa-users"></i> 372</span> <span><i class="fa fa-photo"></i> 43</span>
                                    <span><i class="fa fa-video-camera"></i> 3 </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="item">
                    <div class="timeline-block">
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="">
                                            <img src="../../assets/images/people/woman-3.jpg" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <a href="#" class="pull-right text-muted"><i class="icon-reply-all-fill fa fa-2x "></i></a>

                                        <a href="">Michelle</a>

                                        <span>on 15th January, 2014</span>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="boxed">
                                    <a href="#" class="h4 margin-none">Vegetarian Pizza</a>
                                    <div>
                                        <span class="fa fa-star text-primary"></span>
                                        <span class="fa fa-star text-primary"></span>
                                        <span class="fa fa-star text-primary"></span>
                                        <span class="fa fa-star text-primary"></span>
                                        <span class="fa fa-star-o"></span>
                                    </div>

                                    <div class="media">
                                        <div class="media-left">
                                            <a href="#">
                                                <img src="../../assets/images/people/food1.jpg" alt="" width="80" class="media-object">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor impedit ipsum laborum maiores tempore veritatis....</p>
                                        </div>
                                    </div>
                                    <ul class="icon-list">
                                        <li><i class="fa fa-star fa-fw"></i> 4.8</li>
                                        <li><i class="fa fa-clock-o fa-fw"></i> 20 min</li>
                                        <li><i class="fa fa-graduation-cap fa-fw"></i> Beginner</li>
                                    </ul>
                                </div>

                            </div>

                            <div class="view-all-comments">
                                <a href="#">
                                    <i class="fa fa-comments-o"></i> View all
                                </a>
                                <span>10 comments</span>

                            </div>
                            <ul class="comments">
                                <li class="media">
                                    <div class="media-left">
                                        <a href="">
                                            <img src="../../assets/images/people/guy-6.jpg" width="50" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="pull-right dropdown" data-show-hover="li">
                                            <a href="#" data-toggle="dropdown" class="toggle-button">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Edit</a></li>
                                                <li><a href="#">Delete</a></li>
                                            </ul>
                                        </div>
                                        <a href="" class="comment-author pull-left">Bill D.</a>
                                        <span>Hi Mary, Nice Party</span>
                                        <div class="comment-date">21st September</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-left">
                                        <a href="">
                                            <img src="../../assets/images/people/guy-6.jpg" width="50" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="pull-right dropdown" data-show-hover="li">
                                            <a href="#" data-toggle="dropdown" class="toggle-button">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Edit</a></li>
                                                <li><a href="#">Delete</a></li>
                                            </ul>
                                        </div>
                                        <a href="" class="comment-author pull-left">Mary</a>
                                        <span>Thanks Bill</span>
                                        <div class="comment-date">2 days</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-left">
                                        <a href="">
                                            <img src="../../assets/images/people/guy-6.jpg" width="50" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="pull-right dropdown" data-show-hover="li">
                                            <a href="#" data-toggle="dropdown" class="toggle-button">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Edit</a></li>
                                                <li><a href="#">Delete</a></li>
                                            </ul>
                                        </div>
                                        <a href="" class="comment-author pull-left">Bill D.</a>
                                        <span>What time did it finish?</span>
                                        <div class="comment-date">14 min</div>
                                    </div>
                                </li>
                                <li class="comment-form">
                                    <div class="input-group">

                              <span class="input-group-btn">
                       <a href="" class="btn btn-default"><i class="fa fa-photo"></i></a>
                    </span>

                                        <input type="text" class="form-control" />

                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>

            <!-- // LEFT INNER SIDEBAR -->


            <!-- RIGHT INNER SIDEBAR -->

            <div class="col-xs-12 col-md-6 col-lg-4 hidden-xs hidden-sm">

                <div class="item">
                    <div class="timeline-block">
                        <div class="panel panel-default relative">
                            <img src="../../assets/images/people/place2-full.jpg" alt="place" class="img-responsive">
                            <div class="panel-body panel-boxed text-center">
                                <div class="rating">
                                    <span class="star"></span>
                                    <span class="star filled"></span>
                                    <span class="star filled"></span>
                                    <span class="star filled"></span>
                                    <span class="star filled"></span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <img src="../../assets/images/people/guy-2.jpg" alt="people" class="img-circle" />
                                <img src="../../assets/images/people/woman-1.jpg" alt="people" class="img-circle" />
                                <img src="../../assets/images/people/guy-1.jpg" alt="people" class="img-circle" />
                                <img src="../../assets/images/people/woman-1.jpg" alt="people" class="img-circle" />
                                <a href="#" class="user-count-circle">12+</a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="item">
                    <div class="timeline-block">
                        <div class="panel panel-default relative">
                            <img src="../../assets/images/people/place2-full.jpg" alt="place" class="img-responsive">
                            <div class="panel-body panel-boxed text-center">
                                <div class="rating">
                                    <span class="star"></span>
                                    <span class="star filled"></span>
                                    <span class="star filled"></span>
                                    <span class="star filled"></span>
                                    <span class="star filled"></span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <img src="../../assets/images/people/guy-2.jpg" alt="people" class="img-circle" />
                                <img src="../../assets/images/people/woman-1.jpg" alt="people" class="img-circle" />
                                <img src="../../assets/images/people/guy-1.jpg" alt="people" class="img-circle" />
                                <img src="../../assets/images/people/woman-1.jpg" alt="people" class="img-circle" />
                                <a href="#" class="user-count-circle">12+</a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="item">
                    <div class="timeline-block">
                        <div class="panel panel-default relative">
                            <img src="../../assets/images/people/place2-full.jpg" alt="place" class="img-responsive">
                            <div class="panel-body panel-boxed text-center">
                                <div class="rating">
                                    <span class="star"></span>
                                    <span class="star filled"></span>
                                    <span class="star filled"></span>
                                    <span class="star filled"></span>
                                    <span class="star filled"></span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <img src="../../assets/images/people/guy-2.jpg" alt="people" class="img-circle" />
                                <img src="../../assets/images/people/woman-1.jpg" alt="people" class="img-circle" />
                                <img src="../../assets/images/people/guy-1.jpg" alt="people" class="img-circle" />
                                <img src="../../assets/images/people/woman-1.jpg" alt="people" class="img-circle" />
                                <a href="#" class="user-count-circle">12+</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- //RIGHT INNER SIDEBAR -->


        </div>

    </div>

</template>

<script>

    import { mapState } from 'vuex';
    import PostNew from '../post/PostAdd.vue';
    import Posts from '../post/Posts.vue';

    export default{

        data() {
            return {
                posts: []
            }
        },

        created(){

        },

        computed: {
              loggedIn() {
                  return ((this.authUserStore.authUser !== null) && (this.authUserStore.authUser.access_token !== null));
              },

              ...mapState({
                  authUserStore: state => state.authUser,
                  currentUserStore: state => state.currentUser
              })
        },

        components: {
            appPosts: Posts,
            appNewPostForm: PostNew,
            coverProfile: CoverProfile
        }

    }

</script>

<style>


</style>