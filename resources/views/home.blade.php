@extends('layouts.master')

@section('title')

    Home

@endsection


@section('content')
    
    <div class="container-fluid pt-10">
        <!-- Row -->
        <div class="row"> 
           <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view pa-0">
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                       <div class="sm-data-box bg-red">
                          <div class="container-fluid">
                             <div class="row">
                                <div class="col-xs-8 text-center pl-0 pr-0 data-wrap-left">
                                   <span class="txt-light block counter">
                                      <span class="counter-anim">
                                         {{ formatCurrency($teams_balance->account_balance) }}
                                      </span>
                                   </span>
                                   <span class="weight-500 uppercase-font txt-light block font-13">
                                        Account Balance
                                   </span>
                                </div>
                                <div class="col-xs-4 text-center  pl-0 pr-0 data-wrap-right">
                                   <i class="zmdi zmdi-money txt-light data-right-rep-icon"></i>
                                </div>
                             </div>   
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view pa-0">
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                       <div class="sm-data-box bg-yellow">
                          <div class="container-fluid">
                             <div class="row">
                                <div class="col-xs-8 text-center pl-0 pr-0 data-wrap-left">
                                   <span class="txt-light block counter">
                                      <span class="counter-anim">
                                         {{ formatCurrency($teams_loans->loan_balance) }}
                                      </span>
                                   </span>
                                   <span class="weight-500 uppercase-font txt-light block">
                                      Pending Loans
                                   </span>
                                </div>
                                <div class="col-xs-4 text-center  pl-0 pr-0 data-wrap-right">
                                   <i class="zmdi zmdi-grain txt-light data-right-rep-icon"></i>
                                </div>
                             </div>   
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view pa-0">
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                       <div class="sm-data-box bg-green">
                          <div class="container-fluid">
                             <div class="row">
                                <div class="col-xs-8 text-center pl-0 pr-0 data-wrap-left">
                                    <span class="txt-light block counter">
                                      <span class="counter-anim">
                                         {{ formatCurrency($month_deposits->amount) }}
                                      </span>
                                    </span>
                                    <span class="weight-500 uppercase-font txt-light block">
                                      {{ date('M Y') }} Deposits
                                    </span>
                                </div>
                                <div class="col-xs-4 text-center  pl-0 pr-0 data-wrap-right">
                                   <i class="zmdi zmdi-grain txt-light data-right-rep-icon"></i>
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
        
        <!-- Row -->
        <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view">
                 <div class="panel-heading">
                    <div class="pull-left">
                       <h6 class="panel-title txt-dark">SMS Outbox Stats</h6>
                    </div>
                    <div class="pull-right">
                       <span class="no-margin-switcher">
                          <input type="checkbox" id="morris_switch"  class="js-switch" data-color="#ff2a00" data-secondary-color="#2879ff" data-size="small"/>   
                       </span>  
                    </div>
                    <div class="clearfix"></div>
                 </div>
                 <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                       <div id="morris_extra_line_chart" class="morris-chart" style="height:293px;"></div>
                       <ul class="flex-stat mt-40">
                          <li>
                             <span class="block">Avg Monthly</span>
                             <span class="block txt-dark weight-500 font-18"><span class="counter-anim">3,24,222</span></span>
                          </li>
                          <li>
                             <span class="block">Avg Weekly</span>
                             <span class="block txt-dark weight-500 font-18"><span class="counter-anim">1,23,432</span></span>
                          </li>
                          <li>
                             <span class="block">Trend</span>
                             <span class="block">
                                <i class="zmdi zmdi-trending-up txt-success font-24"></i>
                             </span>
                          </li>
                       </ul>
                    </div>
                 </div>
              </div>
           </div>
              
           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                   <div class="panel panel-default card-view panel-refresh">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading">
                    <div class="pull-left">
                       <h6 class="panel-title txt-dark">SMS Inbox Stats</h6>
                    </div>
                    <div class="pull-right">
                       <a href="#" class="pull-left inline-block refresh mr-15">
                          <i class="zmdi zmdi-replay"></i>
                       </a>
                       <div class="pull-left inline-block dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                          <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>SMS</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Voice</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>USSD</a></li>
                          </ul>
                       </div>
                    </div>
                    <div class="clearfix"></div>
                 </div>
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                       <div>
                          <canvas id="chart_6" height="191"></canvas>
                       </div>   
                       <hr class="light-grey-hr row mt-10 mb-15"/>
                       <div class="label-chatrs">
                          <div class="">
                               <span class="clabels clabels-lg inline-block bg-blue mr-10 pull-left"></span>
                               <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                  <span class="block font-15 weight-500 mb-5">
                                    44.46% 
                                    Deposits
                                  </span>
                                  <span class="block txt-grey">356 Deposits</span>
                               </span>
                             <div id="sparkline_1" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"></div>
                             <div class="clearfix"></div>
                          </div>
                       </div>
                       <hr class="light-grey-hr row mt-10 mb-15"/>
                       <div class="label-chatrs">
                          <div class="">
                              <span class="clabels clabels-lg inline-block bg-green mr-10 pull-left"></span>
                              <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                
                                <span class="block font-15 weight-500 mb-5">
                                  5.54% 
                                  Withdrawals
                                </span>
                                <span class="block txt-grey">36 Withdrawals</span>

                              </span>
                              <div id="sparkline_2" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;">
                                
                              </div>
                             <div class="clearfix"></div>
                          </div>
                       </div>
                       <hr class="light-grey-hr row mt-10 mb-15"/>
                       <div class="label-chatrs">
                          <div class="">
                             <span class="clabels clabels-lg inline-block bg-yellow mr-10 pull-left"></span>
                               <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">

                                 <span class="block font-15 weight-500 mb-5">
                                    50% 
                                    Loans
                                 </span>
                                 <span class="block txt-grey">245 loans</span>

                             </span>
                             <div id="sparkline_3" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"></div>
                             <div class="clearfix"></div>
                          </div>
                       </div>
                    </div>   
                 </div>
              </div>
           </div>
        </div>
        <!-- /Row -->
        
        <!-- Row -->
        <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading">
                    <div class="pull-left">
                       <h6 class="panel-title txt-dark">Newly Created Users</h6>
                    </div>
                    <div class="pull-right">
                       <a href="#" class="pull-left inline-block refresh mr-15">
                          <i class="zmdi zmdi-replay"></i>
                       </a>
                       <a href="#" class="pull-left inline-block full-screen mr-15">
                          <i class="zmdi zmdi-fullscreen"></i>
                       </a>
                       <div class="pull-left inline-block dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                          <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>New</a></li>
                          </ul>
                       </div>
                    </div>
                    <div class="clearfix"></div>
                 </div>
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body row pa-0">
                       <div class="table-wrap">
                          <div class="table-responsive">
                             <table class="table table-hover mb-0">
                                <thead>
                                   <tr>
                                      <th width="30%">Name</th>
                                      <th width="20%">Phone</th>
                                      <th width="30%">Group</th>
                                      <th width="20%">Created</th>
                                   </tr>
                                </thead>
                                <tbody>
                                   
                                   @foreach ($new_users as $user) 
                                   <tr>

                                      <td>
                                        <span class="txt-dark weight-500">
                                          {{ $user->first_name }}
                                          &nbsp;
                                          {{ $user->last_name }}
                                        </span>
                                      </td>

                                      <td>
                                        {{ $user->phone_number }}
                                      </td>

                                      <td>
                                        {{ $user->display_name }}
                                      </td>
                                      
                                      <td>
                                         <span class="txt-dark weight-500">
                                          {{ formatFriendlyDate($user->created_at) }}
                                         </span>
                                      </td>
                                      
                                   </tr>
                                   @endforeach
                                   
                                </tbody>
                             </table>
                          </div>
                       </div>   
                    </div>   
                 </div>
              </div>
           </div>
           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading">
                    <div class="pull-left">
                       <h6 class="panel-title txt-dark"> Group Members</h6>
                    </div>
                    <div class="pull-right">
                       <a href="#" class="pull-left inline-block refresh mr-15">
                          <i class="zmdi zmdi-replay"></i>
                       </a>
                       <a href="#" class="pull-left inline-block full-screen mr-15">
                          <i class="zmdi zmdi-fullscreen"></i>
                       </a>
                       <div class="pull-left inline-block dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                          <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>New</a></li>
                          </ul>
                       </div>
                    </div>
                    <div class="clearfix"></div>
                 </div>
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body row pa-0">
                       <div class="table-wrap">
                          <div class="table-responsive">
                             <table class="table table-hover mb-0">
                                <thead>
                                   <tr>
                                      <th width="35%">Name</th>
                                      <th width="25%">Phone Number</th>

                                      @if (Auth::user()->hasRole('superadministrator'))
                                        <th width="20%">Group</th>
                                      @endif

                                      <th width="20%">Created</th>
                                   </tr>
                                </thead>
                                <tbody>
                                   
                                   @foreach ($teams as $team) 

                                   <tr>

                                      <td>
                                        <span class="txt-dark weight-500">
                                          {{ $team->name }}
                                        </span>
                                      </td>

                                      <td>
                                        <span class="txt-dark weight-500">
                                          {{ $team->phone_number }}
                                        </span>
                                      </td>

                                      @if (Auth::user()->hasRole('superadministrator'))
                                        <td>
                                          @if ($team->name)
                                            {{ $team->name }}
                                          @endif
                                        </td>
                                      @endif
                                      
                                      <td>
                                         <span class="txt-dark weight-500">
                                           {{ $team->created_at->toFormattedDateString() }}
                                         </span>
                                      </td>
                                      
                                   </tr>

                                   @endforeach
                                   
                                </tbody>
                             </table>
                          </div>
                       </div>   
                    </div>   
                 </div>
              </div>
           </div>  
        </div>   
        <!-- Row -->
        
    </div>
         

@endsection
