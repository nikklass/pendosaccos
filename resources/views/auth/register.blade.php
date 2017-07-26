@extends('layouts.authMaster')

@section('title')
    Create Single Account
@endsection

@section('auth_text')
    Want To Create Bulk Accounts?
@endsection

@section('auth_button_text_url')
    /register-bulk
@endsection

@section('auth_button_text')
    Create Bulk
@endsection

@section('content')
    
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
                               </div>   

                               <hr>

                               <div class="form-wrap">
                                  
                                  @if (session('message'))
                                    <div class="alert alert-success text-center">
                                        {{ session('message') }}
                                    </div>
                                  @endif

                                  <form class="form-horizontal" method="POST" action="/register">
                                     
                                     {{ csrf_field() }}

                                     <div  class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                            
                                        <label for="first_name" class="col-sm-3 control-label">
                                           First Name
                                           <span class="text-danger"> *</span>
                                        </label>
                                        <div class="col-sm-9">
                                           <div class="input-group">
                                              <input 
                                                  type="text" 
                                                  class="form-control" 
                                                  id="first_name" 
                                                  name="first_name"
                                                  value="{{ old('first_name') }}" required autofocus>
                                              <div class="input-group-addon"><i class="icon-user"></i></div>
                                           </div>
                                           @if ($errors->has('first_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                           @endif
                                        </div>

                                     </div>

                                     <div  class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                            
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
                                                  value="{{ old('last_name') }}" required>
                                              <div class="input-group-addon"><i class="icon-user"></i></div>
                                           </div>
                                           @if ($errors->has('last_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                           @endif
                                        </div>

                                     </div>

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
                                                  value="{{ old('email') }}" required>
                                              <div class="input-group-addon"><i class="icon-envelope-open"></i></div>
                                           </div>
                                           @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                           @endif
                                        </div>

                                     </div>

                                     <div  class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                            
                                        <label for="phone_number" class="col-sm-3 control-label">
                                           Phone Number
                                           <span class="text-danger"> *</span>
                                        </label>
                                        <div class="col-sm-9">
                                           <div class="input-group">
                                              <input 
                                                  type="text" 
                                                  class="form-control" 
                                                  id="phone_number" 
                                                  name="phone_number"
                                                  maxlength="13" 
                                                  value="{{ old('phone_number') }}" required>
                                              <div class="input-group-addon"><i class="icon-phone"></i></div>
                                           </div>
                                           @if ($errors->has('phone_number'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                                </span>
                                           @endif
                                        </div>

                                     </div>

                                     <!-- <div class="form-group">
                                            
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
                                            
                                        <label for="password2" class="col-sm-3 control-label">
                                           Repeat Password
                                           <span class="text-danger"> *</span>
                                        </label>
                                        <div class="col-sm-9">
                                           <div class="input-group">
                                              <input 
                                                  type="password" 
                                                  class="form-control" 
                                                  id="password2" 
                                                  name="password2"
                                                  required>
                                              <div class="input-group-addon"><i class="icon-lock"></i></div>
                                           </div>
                                           @if ($errors->has('password2'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password2') }}</strong>
                                                </span>
                                           @endif

                                        </div>

                                     </div> -->

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
                                           <button type="submit" class="btn btn-primary btn-block mr-10">Submit</button>
                                        </div>
                                     </div>

                                     <br/>

                                     <!-- <hr>

                                     <div class="text-center">
                                        <a href="{{ route('login') }}">Already Have an Account? Login</a>
                                     </div> -->

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

@endsection
