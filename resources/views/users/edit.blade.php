@extends('layouts.master')

@section('title')

    Edit {{ $user->first_name }}

@endsection


@section('content')
    
    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6">
            <h5 class="txt-dark">Edit User Account - {{ $user->first_name }} {{ $user->last_name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6">
              <a href="{{ route('users.index') }}" class="btn btn-primary btn-icon right-icon pull-right">
                <span>View Users</span> 
                <i class="zmdi zmdi-accounts"></i> 
              </a>
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          
          <div class="table-cell">
             <div class=" ml-auto mr-auto no-float">
                

                  <form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}"> 

                     {{ method_field('PUT') }}
                     {{ csrf_field() }}

                      <div class="row">
                            
                            <div  class="col-sm-12">

                                <div class="panel panel-default border-panel card-view">

                                    <div  class="col-sm-12 col-md-6">

                                        <div class="panel panel-default border-panel card-view">
                                           
                                           <div class="panel-heading">

                                             <div class="pull-left">
                                                <h5 class="panel-title txt-dark">
                                                  <strong>Account Details</strong>
                                                </h5>
                                             </div>
                                             <div class="clearfix"></div>
                                           </div>

                                           <div class="panel-wrapper collapse in">
                                              
                                              <div class="panel-body">               

                                                 <div class="form-wrap">
                                                    
                                                    @if (session('message'))
                                                      <div class="alert alert-success text-center">
                                                          {{ session('message') }}
                                                      </div>
                                                    @endif
                                                    

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
                                                                    value="{{ $user->first_name }}" required autofocus>
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
                                                                    value="{{ $user->last_name }}" required>
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
                                                                    value="{{ $user->email }}" required>
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
                                                                    value="{{ $user->phone_number }}" required>
                                                                <div class="input-group-addon"><i class="icon-phone"></i></div>
                                                             </div>
                                                             @if ($errors->has('phone_number'))
                                                                  <span class="help-block">
                                                                      <strong>{{ $errors->first('phone_number') }}</strong>
                                                                  </span>
                                                             @endif
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

                                                       <hr>

                                                       <div class="form-group">
                                                          <label for="gender" class="col-sm-3 control-label">
                                                             Password
                                                             <span class="text-danger"> *</span>
                                                          </label>
                                                          <div class="col-sm-9">
                                                             <div class="col-sm-12">
                                                                <div class="radio">
                                                                   <input type="radio" 
                                                                      name="change_password" id="change_password" 
                                                                      v-model='password_option'
                                                                      value="keep" checked="">
                                                                   <label for="keep">Don't change Password</label>
                                                                </div>
                                                             </div>
                                                             <div class="col-sm-12">
                                                                <div class="radio">
                                                                   <input type="radio" 
                                                                      name="change_password" id="change_password" 
                                                                      v-model='password_option'
                                                                      value="auto">
                                                                   <label for="auto">AutoGenerate New Password</label>
                                                                </div>
                                                             </div>
                                                             <div class="col-sm-12">
                                                                <div class="radio">
                                                                   <input type="radio" 
                                                                      name="change_password" id="change_password" 
                                                                      v-model='password_option'
                                                                      value="manual">
                                                                   <label for="manual">Manually Set New Password</label>
                                                                </div>
                                                                <div class="input-group" v-if="password_option=='manual'">
                                                                    <input 
                                                                        type="password" 
                                                                        class="form-control" 
                                                                        id="password" 
                                                                        name="password"
                                                                        required>
                                                                    <div class="input-group-addon"><i class="icon-lock"></i></div>
                                                                 </div>
                                                             </div>
                                                          </div>
                                                       </div>                                    

                                                 </div>

                                              </div>

                                           </div>

                                        </div>

                                    </div>

                                    <div  class="col-sm-12 col-md-6">
                                                  
                                           <input type="hidden" name="rolesSelected" :value="rolesSelected">

                                           <div class="panel panel-default border-panel card-view">
                                              
                                              <div class="panel-heading">

                                                 <div class="pull-left">
                                                    <h5 class="panel-title txt-dark">
                                                      <strong>Roles</strong>
                                                    </h5>
                                                 </div>
                                                 <div class="clearfix"></div>
                                              </div>
                                              <div  class="panel-wrapper collapse in">
                                                 <div  class="panel-body">
                                                    <p>
                                                        <ul>
                                                            @foreach ($roles as $role)
                                                            <li>
                                                               <div class="checkbox">
                                                                  <input 
                                                                      id="{{ $role->id }}" 
                                                                      type="checkbox"
                                                                      :value="{{ $role->id }}"
                                                                      v-model="rolesSelected">
                                                                  <label for="{{ $role->id }}"> 
                                                                      {{ $role->display_name }} 
                                                                      &nbsp;&nbsp;
                                                                      <em class="ml-15"> 
                                                                          ({{ $role->description }})
                                                                      </em>
                                                                  </label>
                                                               </div>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </p>
                                                 </div>
                                              </div>

                                           </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                          <div class="col-sm-12">
                                            <button 
                                              type="submit" 
                                              class="btn btn-primary btn-lg btn-block mr-10"
                                               id="submit-btn">
                                               Edit User
                                            </button>
                                          </div>
                                        </div>
                                     </div>

                                    <div class="clearfix"></div>

                                </div>

                            </div>

                      </div>

                  </form>

                
             </div>
          </div>

       </div>
       <!-- /Row --> 
        

    </div>
         

@endsection


@section('page_scripts')

  <script type="text/javascript">

      var app = new Vue({
        el: "#app",
        
        data() {
            return {
              password_option: 'keep',
              rolesSelected: {!!$user->roles->pluck('id')!!}
            }
        },
        
        methods : {

            handleSubmit() {
                $("#submit-btn").LoadingOverlay("show")
            }
            
        }

      });
  </script>
  
@endsection
