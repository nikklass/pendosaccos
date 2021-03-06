@extends('layouts.master')

@section('title')

    <!-- Displaying SMS - {{ $smsoutbox->id }} -->

@endsection


@section('content')
    

    <div class="container-fluid">
          
       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying SMS - {{ $smsoutbox->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              
              {!! Breadcrumbs::render('smsoutbox.show', $smsoutbox->id) !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

        <!-- Row -->
        <div class="row">

          <div class="col-lg-6 col-xs-12">
            <div class="panel panel-default card-view  pa-0">
              <div class="panel-wrapper collapse in">
                <div class="panel-body  pa-0">
                  <div class="profile-box">

                    <div class="profile-info ml-30">
                       
                      <h5 class="block mt-10 mb-5 weight-500 capitalize-font">
                          Phone Number: <span class="txt-danger">{{ $smsoutbox->phone_number }}</span>
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

                                    <div class="follo-data mb-10">
                                      <div class="user-data">
                                        <div class="name block capitalize-font mb-20">
                                            <strong>Message:</strong> 
                                            
                                        </div>
                                        <div>
                                            {{ $smsoutbox->message }}
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data mb-10">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Status:</strong>  
                                            <span class="text-success">
                                                {{ $smsoutbox->status->name }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data mb-10">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Sent at:</strong> 
                                            {{ formatFriendlyDate($smsoutbox->created_at) }}
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
                        <h5>Sms Info</h5>
                    </p>

                    <hr>

                    <div class="row">
                      <div class="col-sm-12">
                          
                          <ul class="list-icons">
                              
                                  <li class="mb-20">
                                      <strong>Company: </strong> {{ $smsoutbox->company->name }}
                                  </li>

                                  @if (Auth::user()->hasRole('superadministrator'))

                                      <li class="mb-20">
                                          <strong>Bulk SMS Name: </strong> 
                                          @if ($smsoutbox->company)
                                          {{ $smsoutbox->company->sms_user_name }}
                                          @endif
                                      </li>

                                  @endif

                              <li class="mb-20">
                                  <strong>Sent at: </strong> 
                                  {{ formatFriendlyDate($smsoutbox->created_at) }}
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

