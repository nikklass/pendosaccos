@extends('layouts.master')

@section('title')

    Create New User

@endsection

@section('css_header')

    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')
    
    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Create New User</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              
              {!! Breadcrumbs::render('users.create') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell vertical-align-middle auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">
                
                <div  class="col-sm-12 col-md-8 col-md-offset-2">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">
                        
                        <div class="panel panel-default card-view">
                           
                           <div class="panel-wrapper collapse in">
                              
                              <div class="panel-body">               

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Create New User</h3>
                                 </div>   

                                 <hr>

                                 <div class="form-wrap">
                                    
                                    
                                    @include('layouts.partials.error_text')


                                    <form class="form-horizontal" method="POST" action="{{ route('users.store') }}"> 

                                       {{ csrf_field() }}

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

                                          @if ($group->id == old('group_id', $group->id))
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
                                                      <strong>{{ $errors->first('group_id') }}</strong>
                                                  </span>
                                             @endif
                                          
                                          </div>

                                       </div>
                                       @else

                                          <div class="form-group">
                                            <label class="control-label col-md-3">group</label>
                                            <div class="col-md-9">
                                            
                                              @if ($user->group)
                                                <p class="form-control-static"> {{ $user->group->name }} </p>
                                                <input 
                                                    type="hidden" 
                                                    name="group_id"
                                                    value="{{ $user->group->id }}">
                                              @endif

                                            </div>
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

                                       <div  class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
                                              
                                          <label for="account_number" class="col-sm-3 control-label">
                                             Account Number
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                             <div class="input-group">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    id="account_number" 
                                                    name="account_number"
                                                    value="{{ old('account_number') }}" required autofocus>
                                                <div class="input-group-addon"><i class="icon-plus"></i></div>
                                             </div>
                                             @if ($errors->has('account_number'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('account_number') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>


                                       <div  class="form-group{{ $errors->has('account_balance') ? ' has-error' : '' }}">
                                              
                                          <label for="account_balance" class="col-sm-3 control-label">
                                             Account Balance
                                          </label>
                                          <div class="col-sm-9">
                                             <div class="input-group">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    id="account_balance" 
                                                    name="account_balance"
                                                    value="{{ old('account_balance') }}">
                                                <div class="input-group-addon"><i class="icon-plus"></i></div>
                                             </div>
                                             @if ($errors->has('account_balance'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('account_balance') }}</strong>
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
                                              <button 
                                                type="submit" 
                                                class="btn btn-lg btn-primary btn-block mr-10"
                                                 id="submit-btn"
                                                 @click="handleSubmit()">
                                                 Submit
                                              </button>
                                          </div>
                                       </div>

                                       <br/>

                                       <hr>

                                       <div class="text-center">
                                          <a href="{{ route('bulk-users.create') }}">
                                          <i class="zmdi zmdi-accounts-add mr-10"></i> Create Bulk Accounts
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
       </div>
       <!-- /Row --> 
        

    </div>
         

@endsection


@section('page_scripts')

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  @include('layouts.partials.error_messages')
  
@endsection

