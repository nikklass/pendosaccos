@extends('layouts.authMaster')

@section('title')
    Login
@endsection

@section('auth_text')
    Forgot Your Password?
@endsection

@section('auth_button_text_url')
    {{ route('password.request') }}
@endsection

@section('auth_button_text')
    Recover Password
@endsection

@section('content')
    
    <div id="app">

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
                                      <h6 class="text-center nonecase-font txt-grey">Please enter your details below</h6>
                                   </div>   

                                   <hr>

                                   <div class="form-wrap">
                                      
                                      <form class="form-horizontal"  role="form" method="POST" action="{{ route('login') }}">
                                      <!-- <form class="form-horizontal"  
                                          role="form" @submit.prevent="handleSubmit()"> -->
                                         
                                         {{ csrf_field() }}

                                         <div  class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            
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
                                                      v-model="email"
                                                      value="{{ old('email') }}" required autofocus>
                                                  <div class="input-group-addon"><i class="icon-envelope-open"></i></div>
                                               </div>
                                               @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                               @endif
                                            </div>

                                         </div>

                                         <div class="form-group">
                                            
                                            <label for="password" class="col-sm-3 control-label">
                                               Password
                                               <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">
                                               <div class="input-group">
                                                  <input 
                                                      type="password" 
                                                      class="form-control" 
                                                      id="password" 
                                                      name="password"
                                                      v-model="password"
                                                      required>
                                                  <div class="input-group-addon"><i class="icon-lock"></i></div>
                                               </div>
                                               @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                               @endif

                                            </div>
                                          </div>

                                          <div class="form-group">
                                              <div class="col-sm-3"></div>
                                              <div class="col-sm-9">
                                                 <div class="checkbox">
                                                    <input id="remember" type="checkbox" name="remember" 
                                                      {{ old('remember') ? 'checked' : '' }}>
                                                    <label for="remember"> Remember Me</label>
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

                                            <a href="{{ route('password.request') }}">
                                                Forgot Password
                                            </a>
                                            
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

@endsection


@section('page_scripts')

  <script type="text/javascript">      

      var app = new Vue({
        el: "#app",
        
        data() {
            return {
                email: '',
                password: ''
            }
        },
        
        methods : {
            
            /*handle  form submit*/
            handleSubmit(){
                
                this.addLoading = true;

                if (this.message !== null) {
          
                  //post form data
                  passport_client_id = "{{ $passport_client_id }}"
                  passport_client_secret = "dbkttj8Smu8Bo1GuCEHfValxOXpHlrVWmoY6jprV"
                  //passport_client_secret = "{{ $passport_client_secret }}"
                  passport_login_url = "{{ $passport_login_url }}"

                  let postData = {
                    'username': this.email,
                    'password': this.password,
                    grant_type: 'password',
                    client_id: passport_client_id,
                    client_secret: passport_client_secret,
                    scope: ''
                  }

                  console.log(postData)

                  
                  axios.post(passport_login_url, postData)
                  .then(response => {

                      this.addLoading = false;

                      console.log(postData)
                      console.log(response)
                      
                  })
                  .catch(error => {
                      console.log(error)
                  })
                  
                }

            }

            

        }

      });
  </script>
  
@endsection