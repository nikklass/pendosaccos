@extends('layouts.master')


@section('title')

    Create New Account

@endsection


@section('css_header')

    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')
    
    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Create New Account</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              
              {!! Breadcrumbs::render('accounts.create') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">
                
                <div  class="col-sm-12 col-md-8 col-md-offset-2">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">
                        
                        <div class="panel panel-default card-view">
                           
                           <div class="panel-wrapper collapse in">
                              
                              <div class="panel-body">               

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Create New Account</h3>
                                 </div>   

                                 <hr>

                                 <div class="form-wrap">
                                 
                                    
                                    @include('layouts.partials.error_text')


                                    <form class="form-horizontal" method="POST" 
                                        action="{{ route('accounts.store') }}"> 

                                       {{ csrf_field() }}

                                       @if (Auth::user()->hasRole('superadministrator'))

                                       <div  class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                                              
                                          <label for="user_id" class="col-sm-3 control-label">
                                             User
                                          </label>
                                          <div class="col-sm-9">
                                            
                                             <select class="selectpicker form-control" 
                                                name="user_id" 
                                                data-style="form-control btn-default btn-outline"
                                                >

                                                @foreach ($users as $user)
                                                <li class="mb-10">
                                                    <option value="{{ $user->id }}"
                                          @if ($user->id == old('user_id', $user->id))
                                              selected="selected"
                                          @endif
                                                    >
                                                      {{ $user->first_name }} 
                                                      &nbsp;
                                                      {{ $user->last_name }}
                                                    </option>
                                                </li>
                                                @endforeach
                                                
                                             </select>

                                             @if ($errors->has('user_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('user_id') }}</strong>
                                                  </span>
                                             @endif
                                          
                                          </div>

                                       </div>
                                       @else

                                          <div class="form-group">
                                            <label class="control-label col-md-3">User</label>
                                            <div class="col-md-9">
                                            
                                              @if ($user->first_name)
                                                <p class="form-control-static"> 
                                                  {{ $user->first_name }} {{ $user->last_name }} 
                                                </p>
                                                <input 
                                                    type="hidden" 
                                                    name="user_id"
                                                    value="{{ $user->id }}">
                                              @endif

                                            </div>
                                          </div>

                                       @endif

                                       <div  class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
                                              
                                          <label for="account_number" class="col-sm-3 control-label">
                                             Account Number
                                          </label>
                                          <div class="col-sm-9">

                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="account_number" 
                                                name="account_number"
                                                value="{{ old('account_number') }}">

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

                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="account_balance" 
                                                name="account_balance"
                                                value="{{ old('account_balance') }}">

                                             @if ($errors->has('account_balance'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('account_balance') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>
                                       

                                        <div  class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                              
                                            <label for="comment" class="col-sm-3 control-label">
                                               Comment
                                            </label>
                                            <div class="col-sm-9">

                                              <textarea 
                                                  rows="6" 
                                                  class="form-control" 
                                                  id="comment" 
                                                  name="comment">{{ old('comment') }}</textarea>

                                               @if ($errors->has('comment'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('comment') }}</strong>
                                                    </span>
                                               @endif
                                            </div>

                                         </div>
                                       
                                       

                                       <br/>

                                       <div class="form-group">
                                          <div class="col-sm-3"></div>
                                          <div class="col-sm-9">
                                              <button 
                                                type="submit" 
                                                class="btn btn-lg btn-primary btn-block mr-10"
                                                 id="submit-btn">
                                                 Submit
                                              </button>
                                          </div>
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
