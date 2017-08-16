@extends('layouts.master')

@section('title')

    Displaying Repayment Id - {{ $repayment->id }}

@endsection


@section('content')
    

    <div class="container-fluid">
          
       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying Repayment Id - {{ $repayment->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('repayments.show', $repayment->id) !!}
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
                              {{ $repayment->user->first_name }}
                              &nbsp;
                              {{ $repayment->user->last_name }}
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
                                        <span class="name block capitalize-font">
                                            <strong>Member Group:</strong> 
                                            {{ $repayment->user->group->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Amount:</strong>  
                                            Ksh 
                                            <span class="text-success">
                                              {{ format_num($repayment->amount) }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Before Balance:</strong>  
                                            Ksh 
                                            <span class="text-primary">
                                              {{ format_num($repayment->before_balance) }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>After Balance:</strong>  
                                            Ksh 
                                            <span class="text-primary">
                                              {{ format_num($repayment->after_balance) }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created:</strong> 
                                           {{ formatFriendlyDate($repayment->created_at) }}
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

                      <a  
                          href="{{ route('repayments.edit', $repayment->id) }}" 
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Repayment</span>
                      </a>

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
                        <h5>Repayment Stats</h5>
                    </p>

                    <hr>

                    <div class="row">

                      <div class="col-sm-12">
                          
                          <ul class="list-icons">

                              <li class="mb-20">
                                  <strong>Loan Id: </strong> 
                                  {{ $repayment->loan->id }}
                              </li>

                              <li class="mb-20">
                                  <strong>Loan Balance: </strong> 
                                  Ksh 
                                  <span class="text-primary">
                                    {{ format_num($repayment->loan->loan_balance) }}
                                  </span>
                              </li>

                              <hr>

                              @if ($repayment->comment)
                              <li class="mb-20">
                                  <strong>Comment: </strong> 
                                  <br/>
                                  {{ $repayment->comment }}
                              </li>
                              @endif

                              

                              <li class="mb-20">
                                  <strong>Created: </strong> 
                                  {{ formatFriendlyDate($repayment->created_at) }}
                              </li>

                              <li class="mb-20">
                                  <strong>Created By: </strong> 
                                  {{ $repayment->creator->first_name }}
                                  {{ $repayment->creator->last_name }}
                              </li>

                              <li class="mb-20">
                                  <strong>Last Updated: </strong> 
                                  {{ formatFriendlyDate($repayment->updated_at) }}
                              </li>

                              <li class="mb-20">
                                  <strong>Last Updated By: </strong> 
                                  {{ $repayment->updater->first_name }}
                                  {{ $repayment->updater->last_name }}
                              </li>

                          </ul>

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

