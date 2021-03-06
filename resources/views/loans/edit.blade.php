@extends('layouts.master')


@section('title')

    Edit Loan Id - {{ $loan->id }}

@endsection


@section('content')
    
    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Edit Loan Id - {{ $loan->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('loans.edit', $loan->id) !!}
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
                    
                    <div class="profile-info ml-30">
                       
                      <h5 class="block mt-10 mb-5 weight-500 capitalize-font">
                          Member Name: 
                          <span class="txt-danger">
                              {{ $loan->user->first_name }}
                              &nbsp;
                              {{ $loan->user->last_name }}
                          </span>
                      </h5>
                      <!-- <h6 class="block capitalize-font pb-20">Developer Geek</h6> -->
                    </div>  
                    <div class="social-info">
                      <div class="row">
                        
                          <div class="col-lg-12">
                            
                              <div class="form-wrap">                                    

                                    @include('layouts.partials.error_text')

                                    <form class="form-horizontal" method="POST" 
                                        action="{{ route('repayments.store') }}"> 

                                       {{ csrf_field() }}

                                       <div  class="form-group">
                                              
                                          <label class="col-sm-3 control-label">
                                             Loan Amount
                                          </label>
                                          <div class="col-sm-9">
                                              <p class="form-control-static"> 
                                              Ksh 
                                              <strong>
                                              {{ format_num($loan->loan_amount) }}
                                              </strong>
                                              </p>
                                          </div>

                                       </div>

                                       <div  class="form-group">
                                              
                                          <label class="col-sm-3 control-label">
                                             Paid Amount
                                          </label>
                                          <div class="col-sm-9">
                                              <p class="form-control-static"> 
                                              Ksh {{ format_num($loan->paid_amount) }}
                                              </p>
                                          </div>

                                       </div>

                                       <div  class="form-group">
                                              
                                          <label class="col-sm-3 control-label">
                                             Loan Balance
                                          </label>
                                          <div class="col-sm-9">
                                              <p class="form-control-static"> 
                                              Ksh 
                                              <strong>
                                              {{ format_num($loan->loan_balance) }}
                                              </strong>
                                              </p>
                                          </div>

                                       </div>
                                       

                                       <div  class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                              
                                          <label for="amount" class="col-sm-3 control-label">
                                             Amount
                                          </label>
                                          <div class="col-sm-9">

                                            <input type="hidden" name="loan_id" value="{{ $loan->id }}">

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
            <div class="panel panel-default card-view pa-0">
              <div class="panel-wrapper collapse in">
                <div  class="panel-body pb-0 ml-20 mr-20">
                    
                    <p class="mb-20">
                        <h5>Repayments</h5>
                    </p>

                    <hr class="small">

                    <div class="row">

                      <div class="col-sm-12">

                          <p class="mb-20">

                              @if (!count($loan->repayments))

                                  No repayment made yet

                              @else

                                  <table class="table">
                                      
                                      <thead>

                                          <tr>
                                              <th class="text-right">Amount</th>
                                              <th class="text-right">Start Balance</th>
                                              <th class="text-right">After Balance</th>
                                              <th>Created At</th>
                                          </tr>

                                      </thead>
                                  
                                      <tbody>
                                          
                                          @foreach ($repayments as $repayment)
                                            <tr>
                                              <td align="right">
                                                {{ format_num($repayment->amount) }}
                                              </td>
                                              <td align="right">
                                                {{ format_num($repayment->before_balance) }}
                                              </td>
                                              <td align="right">
                                                {{ format_num($repayment->after_balance) }}
                                              </td>
                                              <td>{{ formatFriendlyDate($repayment->created_at) }}</td>
                                            </tr>
                                          @endforeach

                                          <tr>
                                            <td colspan="4">
                                              <div class="text-center mt-20">
                                                 {{ $repayments->links() }}
                                              </div> 
                                            </td>
                                          </tr>
                                          
                                      </tbody>

                                  </table>

                              @endif

                          </p>

                      </div>

                    </div>

                </div>
              </div>
            </div>

          </div>

        </div>
        <!-- /Row -->
        

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
                                    <h3 class="text-center txt-dark mb-10">
                                        Edit Loan Id - {{ $loan->id }}
                                    </h3>
                                 </div>   

                                 <hr>

                                 <div class="form-wrap">
                                    
                                    @include('layouts.partials.error_text')

                                    <form class="form-horizontal" method="POST" 
                                        action="{{ route('loans.update', $loan->id) }}"> 

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div class="form-group">
                                          <label class="control-label col-md-3">User</label>
                                          <div class="col-md-9">
                                          
                                            @if ($loan->user->first_name)
                                              <p class="form-control-static"> 
                                                {{ $loan->user->first_name }} 
                                                &nbsp;
                                                {{ $loan->user->last_name }} 
                                              </p>
                                              <input 
                                                  type="hidden" 
                                                  name="user_id"
                                                  value="{{ $loan->user->id }}">
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
                                                value="{{ $loan->loan_amount }}">

                                             @if ($errors->has('amount'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('amount') }}</strong>
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
                                                  name="comment">{{ $loan->comment }}</textarea>

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
