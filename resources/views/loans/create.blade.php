@extends('layouts.master')


@section('title')

    Create New Loan

@endsection


@section('css_header')

    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')
    
    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">
                Create New Loan
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              
              {!! Breadcrumbs::render('loans.create') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->


       <!-- Row -->
        <div class="row mt-15">

          <div class="col-lg-6 col-xs-12">
            <div class="panel panel-default card-view  pa-0">
              <div class="panel-wrapper collapse in">
                <div class="panel-body  pa-0">
                  <div class="profile-box">
                    
                    <div class="social-info">
                      <div class="row">
                        
                          <div class="col-lg-12">
                            
                              <div class="form-wrap">                                    

                                    @include('layouts.partials.error_text')

                                    <form class="form-horizontal" method="POST" 
                                        action="{{ route('loans.store') }}"> 

                                       {{ csrf_field() }}


                                       @if ((Auth::user()->hasRole('superadministrator')) ||
                                       (Auth::user()->hasRole('administrator')))

                                       <div  class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                                              
                                          <label for="user_id" class="col-sm-3 control-label">
                                             Member
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
                                       
                                       @endif

                                       <div  class="form-group{{ $errors->has('loan_type_id') ? ' has-error' : '' }}">
                                              
                                          <label for="loan_type_id" class="col-sm-3 control-label">
                                             Loan Type
                                          </label>
                                          <div class="col-sm-9">
                                        
                                             <select class="selectpicker form-control" 
                                                name="loan_type_id" 
                                                data-style="form-control btn-default btn-outline"
                                                >

                                                @foreach ($loan_types as $loan_type)
                                                <li class="mb-10">
                                                    <option value="{{ $user->id }}"
                                          @if ($loan_type->id == old('loan_type_id', $loan_type->id))
                                              selected="selected"
                                          @endif
                                                    >
                                                      {{ $loan_type->name }} 
                                                    </option>
                                                </li>
                                                @endforeach
                                                
                                             </select>

                                             @if ($errors->has('loan_type_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('loan_type_id') }}</strong>
                                                  </span>
                                             @endif
                                          
                                          </div>

                                       </div>


                                       <div  class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                              
                                          <label for="amount" class="col-sm-3 control-label">
                                             Amount
                                          </label>
                                          <div class="col-sm-9">


                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="amount" 
                                                name="amount"
                                                value="{{ old('amount') }}">

                                             @if ($errors->has('amount'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('amount') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                              
                                          <label for="interest" class="col-sm-3 control-label">
                                             Interest % p.a.
                                          </label>
                                          <div class="col-sm-3">


                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="interest" 
                                                name="interest"
                                                value="{{ old('interest') }}">

                                             @if ($errors->has('interest'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('interest') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                          <label for="period" class="col-sm-3 control-label">
                                             Period (months)
                                          </label>
                                          <div class="col-sm-3">

                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="period" 
                                                name="period"
                                                value="{{ old('period') }}">

                                             @if ($errors->has('period'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('period') }}</strong>
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

          <div class="col-lg-6 col-xs-12">
            
          @if (($group) && (Auth::user()->hasRole('administrator')))
            <div class="panel panel-default card-view pa-0">
              
              <div  class="panel-wrapper collapse in">
                 
                 <div  class="panel-body pb-0 ml-20 mr-20">
                    
                      <p class="mb-20">
                          <h5>Group Account Balance</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-sm-12">
                            
                            <div class="user_options_tall nicescroll-bar">
                                
                                <h3 class="text-left mb-20">
                                  Ksh 
                                  <span class="text-success">
                                    {{ format_num($group->account_balance) }}
                                  </span>
                                </h3> 

                            </div>

                        </div>
                      </div>

                 </div>

              </div>

            </div>

            <div class="panel panel-default card-view pa-0">
              <div class="panel-wrapper collapse in">
                <div  class="panel-body pb-0 ml-20 mr-20">
                    
                    <p class="mb-20">
                        <h5>Total Loans</h5>
                    </p>

                    <hr class="small">

                    <div class="row">

                      <div class="col-sm-12">

                          <h3 class="text-left mb-20">
                            Ksh 
                            <span class="text-success">
                              {{ format_num($group->account_balance) }}
                            </span>
                          </h3> 

                      </div>

                    </div>

                </div>
              </div>
            </div>

            @endif

            

          </div>

        </div>
        <!-- /Row -->

    </div>

@endsection


@section('page_scripts')

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  @include('layouts.partials.error_messages')
  
@endsection
