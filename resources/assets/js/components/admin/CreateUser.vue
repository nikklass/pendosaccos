<template>

    <div class="wrapper theme-1-active pimary-color-red">

        <app-main-includes></app-main-includes>

        <div class="page-wrapper">

            <div class="container-fluid pt-25">
                
                <!-- Row -->
                 <div class="table-struct full-width full-height">
                    <div class="table-cell vertical-align-middle">
                       <div class="auth-form  ml-auto mr-auto no-float">
                          <div class="row">
                             <div class="col-sm-12 col-xs-12">
                                
                                <div class="panel panel-default card-view">
                                   
                                   <div class="panel-wrapper collapse in">
                                      
                                      <div class="panel-body">               

                                         <div class="mb-30">
                                            <h3 class="text-center txt-dark mb-10">Create a New User</h3>
                                            <h6 class="text-center nonecase-font txt-grey">
                                                Please enter user details below
                                            </h6>
                                         </div>   

                                         <hr>

                                         <div class="form-wrap">
                                            
                                            <form class="form-horizontal" 
                                                  @click.prevent="handleRegisterSubmit()">

                                               <div class="form-group">
                                                  <label for="first_name" class="col-sm-3 control-label">
                                                     First Name
                                                     <span class="text-danger"> *</span>
                                                  </label>
                                                  <div class="col-sm-9">
                                                     <div class="input-group">
                                                        <input type="text" 
                                                            class="form-control" 
                                                            id="first_name" 
                                                            name="first_name"
                                                            v-validate="{ rules: { required: true } }">
                                                        <div class="input-group-addon"><i class="icon-user"></i></div>
                                                     </div>
                                                  </div>
                                               </div>

                                               <div class="form-group">
                                                  <label for="last_name" class="col-sm-3 control-label">
                                                     Last Name
                                                     <span class="text-danger"> *</span>
                                                  </label>
                                                  <div class="col-sm-9">
                                                     <div class="input-group">
                                                        <input 
                                                          type="text" 
                                                          class="form-control" 
                                                          id="last_name" 
                                                          name="last_name"
                                                          v-validate="{ rules: { required: true } }">
                                                        <div class="input-group-addon"><i class="icon-user"></i></div>
                                                     </div>
                                                  </div>
                                               </div>

                                               <div class="form-group">
                                                  <label for="email" class="col-sm-3 control-label">
                                                     Email Address
                                                     <span class="text-danger"> *</span>
                                                  </label>
                                                  <div class="col-sm-9">
                                                     <div class="input-group">
                                                        <input 
                                                          type="email" 
                                                          class="form-control" 
                                                          id="email" 
                                                          name="email"
                                                          v-validate="{ rules: { required: true, email: true } }">
                                                        <div class="input-group-addon"><i class="icon-envelope-open"></i></div>
                                                     </div>
                                                     <span v-show="errors.has('email')">
                                                        {{ errors.first('email') }}
                                                     </span>
                                                  </div>
                                               </div>

                                               <div class="form-group">
                                                  <label for="password" class="col-sm-3 control-label">
                                                     Password
                                                     <span class="text-danger"> *</span>
                                                  </label>
                                                  <div class="col-sm-9">
                                                     <div class="input-group">
                                                        <input type="password" class="form-control" id="password" name="password">
                                                        <div class="input-group-addon"><i class="icon-lock"></i></div>
                                                     </div>
                                                  </div>
                                               </div>                                            

                                               <div class="form-group">
                                                  <label for="gender" class="col-sm-3 control-label">
                                                     Gender
                                                     <span class="text-danger"> *</span>
                                                  </label>
                                                  <div class="col-sm-9">
                                                     <div class="col-sm-6">
                                                        <div class="radio">
                                                           <input type="radio" name="gender" id="gender" value="m" checked="">
                                                           <label for="m">Male</label>
                                                        </div>
                                                     </div>
                                                     <div class="col-sm-6">
                                                        <div class="radio">
                                                           <input type="radio" name="gender" id="gender" value="f">
                                                           <label for="f">Female</label>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>

                                               <br/>

                                               <div class="form-group">
                                                  <div class="col-sm-3"></div>
                                                  <div class="col-sm-9">
                                                    <button type="submit" 
                                                          class="btn btn-primary btn-block mr-10"
                                                          id="submit-btn">
                                                          Submit
                                                    </button>
                                                  </div>
                                               </div>

                                               <br/>

                                               <hr>

                                               <div class="text-center">
                                                  <router-link :to="{ name: 'login' }" >
                                                      <a>
                                                         <i class="fa fa-users"></i> 
                                                         &nbsp;
                                                         View Users List
                                                      </a>
                                                  </router-link>
                                               </div>

                                            </form>

                                         </div>

                                      </div>

                                   </div>

                                </div>   
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
                 <!-- /Row -->  
                 
            </div>

            <app-footer></app-footer>

        </div>

    </div>

</template>

<script>

    import { mapState } from 'vuex';
    import { addUserUrl, getHeader } from './../../config';
    import { clientId, clientSecret } from './../../.env';

    import MainIncludes from './../includes/MainIncludes.vue';
    import Footer from './../includes/Footer.vue';

    export default {

        components: {
            appMainIncludes: MainIncludes,
            appFooter: Footer
        },

        data() {
            return {
                form: new Form({
                    username: 'antiv_boy@yahoo.com',
                    password: '123',
                    grant_type: 'password',
                    client_id: clientId,
                    client_secret: clientSecret,
                    scope: ''
                }),
                addLoading: false,
                showsuccess: false,
                showerror: false,
                formOk: false
            }
        }, 

        computed: {
            loggedIn() {
                return ((this.authUserStore.authUser !== null) && (this.authUserStore.authUser.access_token !== null));
            },
            ...mapState({
                authUserStore: state => state.authUser
            })
        },
        
        methods : {

            handleRegisterSubmit() {

                this.addLoading = true;

                $("#submit-btn").LoadingOverlay("show");

                const authUser = {}

                //post form data
                this.form.post(addUserUrl)
                    .then(response => {

                        this.addLoading = false;

                        $("#submit-btn").LoadingOverlay("hide");

                        if (response.status === 200) {
                            authUser.access_token = response.data.access_token
                            authUser.refresh_token = response.data.refresh_token
                            //store tokens locally
                            window.localStorage.setItem('authUser', JSON.stringify(authUser))
                        }

                        //console.log(response);

                    })
                    .catch(error => console.log(error));

            }
            
        }

    }



</script>