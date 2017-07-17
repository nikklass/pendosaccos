<template>
	
	<div class="page-wrapper wrapper pa-0 ma-0 auth-page">
        
        <app-auth-header-login></app-auth-header-login>

        <div class="container-fluid"> 
             <!-- Row -->
             <div class="table-struct full-width full-height">
                <div class="table-cell vertical-align-middle auth-form-wrap">
                   <div class="auth-form  ml-auto mr-auto no-float">
                      <div class="row">
                         <div class="col-sm-12 col-xs-12">
                            
                            <div class="panel panel-default card-view">
                               
                               <div class="panel-wrapper collapse in">

                                  <div class="panel-body">   

                                     <div class="mb-30">                                  
                                        <h3 class="text-center txt-dark mb-10">Login</h3>
                                        <h6 class="text-center nonecase-font txt-grey">
                                            Please enter your details below
                                        </h6>
                                     </div>   

                                     <hr>

                                     <div class="form-wrap">
                                        
                                        <form class="form-horizontal" @submit.prevent="handleLoginSubmit()">
                                           
                                           <!-- <div class="alert alert-success text-center" v-if="showsuccess">
                                              Success
                                           </div> -->

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
                                                        v-model="form.username" 
                                                        required>
                                                    <div class="input-group-addon">
                                                        <i class="icon-envelope-open"></i>
                                                    </div>
                                                 </div>
                                              </div>

                                              

                                           </div>

                                           <div class="form-group">
                                              
                                              <label for="password" class="col-sm-3 control-label">
                                                 Password
                                                 <span class="text-danger"> *</span>
                                              </label>
                                              <div class="col-sm-9">
                                                 <div class="input-group">
                                                    <input type="password" 
                                                        class="form-control" 
                                                        id="password" 
                                                        v-model="form.password" 
                                                        required>
                                                    <div class="input-group-addon"><i class="icon-lock"></i></div>
                                                 </div>
                                              </div>

                                              <form-error v-if="errors.password" :errors="errors">
                                                  @{{ errors.password }}
                                              </form-error>

                                           </div>

                                           <div class="form-group">
                                              <div class="col-sm-3"></div>
                                              <div class="col-sm-9">
                                                 <div class="checkbox">
                                                    <input id="checkbox_2" type="checkbox" name="remember_me">
                                                    <label for="checkbox_2"> Remember me</label>
                                                 </div>
                                              </div>
                                           </div>

                                           <br/>

                                           <div class="form-group">
                                              <div class="col-sm-3"></div>
                                              <div class="col-sm-9">
                                                 <button type="submit" class="btn btn-primary btn-block mr-10" id="submit-btn">
                                                     &nbsp; Submit
                                                 </button>
                                              </div>
                                           </div>

                                           <br/>

                                           <hr>

                                           <div class="text-center">
                                              
                                              <router-link :to="{ name: 'register' }" >
                                                <a>
                                                   Don't Have an Account Yet? Register
                                                </a>
                                              </router-link>

                                              &nbsp;&nbsp; | &nbsp;&nbsp;

                                              <router-link :to="{ name: 'forgotPassword' }" >
                                                  <a>
                                                     Forgot Password
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

  </div>

</template>


<script> 

    import { mapState } from 'vuex';
    import { loginUrl, userUrl, getHeader } from './../../config';
    import { clientId, clientSecret } from './../../.env';
    import AuthHeaderLogin from './../includes/partials/AuthHeaderLogin.vue';
    import FormError from './../includes/FormError.vue';

    export default {

        data() {
            return {
                form: new Form({
                    username: '',
                    password: '',
                    grant_type: 'password',
                    client_id: clientId,
                    client_secret: clientSecret,
                    scope: ''
                }),
                addLoading: false,
                showsuccess: false,
                showerror: false
            }
        },

        components: {
            appAuthHeaderLogin: AuthHeaderLogin,
            FormError 
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

            handleLoginSubmit() {

                this.addLoading = true;

                $("#submit-btn").LoadingOverlay("show");

                const authUser = {}

                //post form data
                this.form.post(loginUrl)
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

                        //get user data 
                        axios.get(userUrl, { headers: getHeader() })
                            .then(successdata => {

                                //save new user details
                                authUser.id = successdata.data.id;
                                authUser.email = successdata.data.email;
                                authUser.first_name = successdata.data.first_name;
                                authUser.last_name = successdata.data.last_name;
                                authUser.gender = successdata.data.gender;

                                window.localStorage.setItem('authUser', JSON.stringify(authUser));

                                //login the user
                                this.$store.dispatch("setAuthUser", authUser);

                                //redirect to home
                                this.$router.push({ name: 'home' });                                

                            })
                            .catch(error => console.log(error));

                    })
                    .catch(error => {
                        console.log(error)
                        // form submission failed, pass form  errors to errors array
                        this.$emit('errors', error.data);
                       
                    });

            }
            
        }
       
    }

</script>