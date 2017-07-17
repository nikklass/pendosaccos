<template>
	
  	<div class="page-wrapper wrapper pa-0 ma-0 auth-page">
          
          <app-auth-header-register></app-auth-header-register>

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
                                        <h3 class="text-center txt-dark mb-10">Create a New Account</h3>
                                        <h6 class="text-center nonecase-font txt-grey">Please enter your details below</h6>
                                     </div>   

                                     <hr>

                                     <div class="form-wrap">
                                        
                                        <form class="form-horizontal" method="POST" action="/user/register">

                                           <div class="form-group">
                                              <label for="first_name" class="col-sm-3 control-label">
                                                 First Name
                                                 <span class="text-danger"> *</span>
                                              </label>
                                              <div class="col-sm-9">
                                                 <div class="input-group">
                                                    <input type="text" class="form-control" id="first_name" name="first_name">
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
                                                    <input type="text" class="form-control" id="last_name" name="last_name">
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
                                                    <input type="email" class="form-control" id="email" name="email">
                                                    <div class="input-group-addon"><i class="icon-envelope-open"></i></div>
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
                                                    <input type="password" class="form-control" id="password" name="password">
                                                    <div class="input-group-addon"><i class="icon-lock"></i></div>
                                                 </div>
                                              </div>
                                           </div>

                                           <div class="form-group">
                                              <label for="password2" class="col-sm-3 control-label">
                                                 Repeat Password
                                                 <span class="text-danger"> *</span>
                                              </label>
                                              <div class="col-sm-9">
                                                 <div class="input-group">
                                                    <input type="password" class="form-control" id="password2" name="password2">
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

                                           <div class="form-group">
                                              <div class="col-sm-3"></div>
                                              <div class="col-sm-9">
                                                 <div class="checkbox">
                                                    <input id="checkbox_2" type="checkbox">
                                                    <label for="checkbox_2"> I accept <a href="">terms and conditions</a></label>
                                                 </div>
                                              </div>
                                           </div>

                                           <br/>

                                           <div class="form-group">
                                              <div class="col-sm-3"></div>
                                              <div class="col-sm-9">
                                                 <button type="submit" class="btn btn-primary btn-block mr-10">Submit</button>
                                              </div>
                                           </div>

                                           <br/>

                                           <hr>

                                           <div class="text-center">
                                              <router-link :to="{ name: 'login' }" >
                                                  <a>
                                                     Already Have an Account? Login
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
    import AuthHeaderRegister from './../includes/partials/AuthHeaderRegister.vue';

    export default {

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
                showerror: false
            }
        },

        components: {
            appAuthHeaderRegister: AuthHeaderRegister
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

                const authUser = {}

                //post form data
                this.form.post(loginUrl)
                    .then(response => {

                        this.addLoading = false;

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

                                window.localStorage.setItem('authUser', JSON.stringify(authUser));

                                //login the user
                                this.$store.dispatch("setAuthUser", authUser);

                                //redirect to dashboard
                                this.$router.push({ name: 'home' });

                            })
                            .catch(error => console.log(error));

                    })
                    .catch(error => console.log(error));

            }
            
        }
       
    }

</script>