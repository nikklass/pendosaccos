@extends('layouts.master')

@section('title')

    Displaying Loan Id - {{ $loan->id }}

@endsection


@section('content')
    

    <div class="container-fluid">
          
       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying Loan Id - {{ $loan->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('loans.show', $loan->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

        <!-- Row -->
        <div class="row mt-15">

          @include('layouts.partials.error_text')

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
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Member Group:</strong> 
                                            &nbsp;&nbsp; 
                                            {{ $loan->user->group->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Loan Amount:</strong> 
                                            &nbsp;&nbsp; 
                                            Ksh 
                                            <span class="text-primary">
                                              {{ format_num($loan->loan_amount) }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Loan Terms:</strong> 
                                            &nbsp;&nbsp; 
                                            <span>
                                              {{ $loan->interest }}% P.A. / 
                                              {{ $loan->period }} Months Period
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Amount Paid:</strong> 
                                            &nbsp;&nbsp; 
                                            Ksh 
                                            <span>
                                              {{ format_num($loan->paid_amount) }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Loan Balance:</strong> 
                                            &nbsp;&nbsp; 
                                            Ksh 
                                            <span class="text-success">
                                              {{ format_num($loan->loan_balance) }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    

                                    @if ($loan->comment)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Comment:</strong> 
                                            &nbsp;&nbsp; 
                                            {{ $loan->comment }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created At:</strong> 
                                           &nbsp;&nbsp;
                                           {{ formatFriendlyDate($loan->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div> 

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created By:</strong> 
                                           &nbsp;&nbsp;
                                            {{ $loan->creator->first_name }}
                                            {{ $loan->creator->last_name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>  

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Last Updated At:</strong> 
                                           &nbsp;&nbsp;
                                           {{ formatFriendlyDate($loan->updated_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div> 

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Last Updated By:</strong> 
                                           &nbsp;&nbsp;
                                            {{ $loan->updater->first_name }}
                                            {{ $loan->updater->last_name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>  

                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>

                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <a  
                              href="{{ route('loans.edit', $loan->id) }}" 
                              class="btn btn-success btn-block btn-outline btn-anim mt-30">
                              <i class="fa fa-pencil"></i>
                              <span class="btn-text">Edit Loan</span>
                          </a>
                        </div>
                        <div class="col-sm-6">
                          <a  
                              href="{{ route('repayments.create', 'loan_id='. $loan->id) }}" 
                              class="btn btn-primary btn-block btn-outline btn-anim mt-30">
                              <i class="fa fa-plus"></i>
                              <span class="btn-text">Add Repayment</span>
                          </a>
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
                        <h5>Loan Repayments</h5>
                    </p>

                    <hr>

                    <div class="row">

                      <div class="col-sm-12">

                          <p class="mb-20">

                              @if (!count($repayments))

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
      
    </div>
         

@endsection

