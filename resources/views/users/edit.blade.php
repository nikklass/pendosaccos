@extends('layouts.master')

@section('title')

    Edit User - {{ $user->first_name }}

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')
    
    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6">
            <h5 class="txt-dark">Edit User - {{ $user->first_name }} {{ $user->last_name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6">
              {!! Breadcrumbs::render('users.edit', $user->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          
          <div class="table-cell">
             <div class=" ml-auto mr-auto no-float">

                
                  @include('layouts.partials.error_text')


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
                                                      @if (Auth::user()->hasRole('superadministrator'))
                                                       
                                                       <div  class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">
                                                              
                                                          <label for="group_id" class="col-sm-3 control-label">
                                                             Group
                                                             <span class="text-danger"> *</span> 
                                                          </label>
                                                          <div class="col-sm-9">
                                                            
                                                             <select class="selectpicker form-control" 
                                                                name="group_id" 
                                                                data-style="form-control btn-default btn-outline"
                                                                required>

                                                                @foreach ($groups as $group)
                                                                  <li class="mb-10">
                                                                      <option value="{{ $group->id }}"

                                                            @if ($group->id == old('group_id', $user->group->id))
                                                                selected="selected"
                                                            @endif
                                                                      >
                                                                        {{ $group->name }}
                                                                      </option>
                                                                  </li>
                                                                @endforeach
                                                                
                                                             </select>

                                                             @if ($errors->has('group_id'))
                                                                <span class="help-block">
                                                                    <strong>
                                                                      {{ $errors->first('group_id') }}
                                                                    </strong>
                                                                </span>
                                                             @endif
                                                          
                                                          </div>

                                                       </div>

                                                       @else

                                                          <div class="form-group">
                                                            <label class="control-label col-md-3">Group</label>
                                                            <div class="col-md-9">
                                                            
                                                              @if ($user->group)
                                                                <p class="form-control-static"> {{ $user->group->name }} </p>
                                                                <input 
                                                                    type="hidden" 
                                                                    name="group_id"
                                                                    value="{{ $user->group_id }}">
                                                              @endif

                                                            </div>
                                                          </div>

                                                       @endif

                                                      <div  class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
                                              
                                                        <label for="account_number" class="col-sm-3 control-label">
                                                           Account No.
                                                           <span class="text-danger"> *</span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                           <div class="input-group">
                                                              <input 
                                                                  type="text" 
                                                                  class="form-control" 
                                                                  id="account_number" 
                                                                  name="account_number"
                                                                  value="{{ $user->account_number }}" 
                                                                  required autofocus>
                                                              <div class="input-group-addon"><i class="icon-plus"></i></div>
                                                           </div>
                                                           @if ($errors->has('account_number'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('account_number') }}</strong>
                                                                </span>
                                                           @endif
                                                        </div>

                                                      </div>

                                                      <div  class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
                                              
                                                        <label for="account_balance" class="col-sm-3 control-label">
                                                           Account Bal.
                                                           <span class="text-danger"> *</span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                           <div class="input-group">
                                                              <input 
                                                                  type="text" 
                                                                  class="form-control" 
                                                                  id="account_balance" 
                                                                  name="account_balance"
                                                                  value="{{ $user->account_balance }}" 
                                                                  required autofocus>
                                                              <div class="input-group-addon"><i class="icon-plus"></i></div>
                                                           </div>
                                                           @if ($errors->has('account_balance'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('account_balance') }}</strong>
                                                                </span>
                                                           @endif
                                                        </div>

                                                     </div>

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
                                                                    value="{{ $user->first_name }}" required>
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

                                                       <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                              
                                                          <label for="email" class="col-sm-3 control-label">
                                                             Email Address
                                                          </label>
                                                          <div class="col-sm-9">
                                                             <div class="input-group">
                                                                <input 
                                                                    type="email" 
                                                                    class="form-control" 
                                                                    id="email" 
                                                                    name="email"
                                                                    value="{{ $user->email }}" >
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
                                                             Phone No.
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
                                                                    value="{{ old('phone_number', $user->phone_number)}}" required>
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
                                                                   <input type="radio" 
                                                                   name="gender" 
                                                                   id="gender" value="m" 
                                                                   @if ($user->gender == 'm')
                                                                    checked
                                                                   @endif
                                                                   >
                                                                   <label for="m">Male</label>
                                                                </div>
                                                             </div>
                                                             <div class="col-sm-6">
                                                                <div class="radio">
                                                                   <input type="radio" 
                                                                   name="gender" 
                                                                   id="gender" value="f"
                                                                   @if ($user->gender == 'f')
                                                                    checked
                                                                   @endif
                                                                   >
                                                                   <label for="f">Female</label>
                                                                </div>
                                                             </div>
                                                          </div>
                                                       </div>

                                                       <hr>

                                                       <div class="form-group">
                                                          <label for="gender" class="col-sm-3 control-label">
                                                             Password
                                                          </label>
                                                          <div class="col-sm-9">
                                                             <div class="col-sm-12">
                                                                <div class="radio">
                                                                   <input type="radio" 
                                                                      name="change_password" 
                                                                      id="change_password" 
                                                                      v-model="password_option"
                                                                      value="keep">
                                                                   <label for="keep">Don't change Password</label>
                                                                </div>
                                                             </div>
                                                             <div class="col-sm-12">
                                                                <div class="radio">
                                                                   <input type="radio" 
                                                                      name="password_option" 
                                                                      id="password_option" 
                                                                      v-model="password_option"
                                                                      value="auto">
                                                                   <label for="auto">AutoGenerate New Password</label>
                                                                </div>
                                                             </div>
                                                             <div class="col-sm-12">
                                                                <div class="radio">
                                                                   <input type="radio" 
                                                                      name="password_option" 
                                                                      id="password_option" 
                                                                      v-model="password_option"
                                                                      value="manual">
                                                                   <label for="manual">Manually Set New Password</label>
                                                                </div>
                                                                <div class="input-group" 
                                                                    v-if="password_option=='manual'">
                                                                    <input 
                                                                        type="password" 
                                                                        class="form-control" 
                                                                        id="password" 
                                                                        name="password"
                                                                        >
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


                                    @if (Auth::user()->hasRole('superadministrator'))

                                        <div  class="col-sm-12 col-md-6">
                                                      
                                               <input type="hidden" name="rolesSelected" :value="rolesSelected">

                                               <div class="panel panel-default border-panel card-view">
                                                  
                                                  <div class="panel-heading">

                                                     <div class="pull-left">
                                                        <h5 class="panel-title txt-dark">
                                                          <strong>User Roles</strong>
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

                                    @else

                                        <div  class="col-sm-12 col-md-6">
                                                      
                                               <input type="hidden" name="rolesSelected" :value="rolesSelected">

                                               <div class="panel panel-default border-panel card-view">
                                                  
                                                  <div class="panel-heading">

                                                     <div class="pull-left">
                                                        <h5 class="panel-title txt-dark">
                                                          <strong>User Roles</strong>
                                                        </h5>
                                                     </div>
                                                     <div class="clearfix"></div>
                                                  </div>
                                                  <div  class="panel-wrapper collapse in">
                                                     <div  class="panel-body">
                                                       
                                                        <p>
                                                            <ul>
                                                                <li>
                                                                   <div>

                                                                          @if (count($user->roles))
                                                                              
                                                      <ul>
                                                      @foreach ($user->roles as $role)
                                                        <li class="mt-10">
                                                            <i class="fa fa-genderless text-success mr-5"></i>
                                                            {{ $role->display_name }} 
                                                            <em class="ml-15"> ({{ $role->description }})</em>
                                                        </li>
                                                      @endforeach
                                                      </ul>

                                                                              

                                                                          @else
                                                                                  
                                                                                No roles assigned

                                                                          @endif

                                                                   </div>
                                                                </li>
                                                            </ul>
                                                        </p>
                                                        
                                                     </div>
                                                  </div>

                                               </div>

                                        </div>

                                    @endif
                            

                                    <div class="form-group">
                                        <div class="row">
                                          <div class="col-sm-12">
                                            <button 
                                              type="submit" 
                                              class="btn btn-primary btn-lg btn-block"
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

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  <script type="text/javascript">

      var app = new Vue({
        el: "#app",
        
        data() {
            return {
              password_option: 'keep',
              rolesSelected: {!!$user->roles->pluck('id')!!}
            }
        }
        
      });
  </script>
  
@endsection
