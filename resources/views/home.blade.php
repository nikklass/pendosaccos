@extends('layouts.master')

@section('title')

    Home

@endsection


@section('content')
    
    <div class="container-fluid pt-25">
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
                                      Ksh. <span class="counter-anim">2,333,200,000</span>
                                   </span>
                                   <span class="weight-500 uppercase-font txt-light block font-13">Shares</span>
                                </div>
                                <div class="col-xs-4 text-center  pl-0 pr-0 data-wrap-right">
                                   <i class="zmdi zmdi-male-female txt-light data-right-rep-icon"></i>
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
                                      Ksh. <span class="counter-anim">46,000</span>
                                   </span>
                                   <span class="weight-500 uppercase-font txt-light block">Savings</span>
                                </div>
                                <div class="col-xs-4 text-center  pl-0 pr-0 data-wrap-right">
                                   <i class="zmdi zmdi-redo txt-light data-right-rep-icon"></i>
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
                                      Ksh. <span class="counter-anim">4,054,876</span>
                                   </span>
                                   <span class="weight-500 uppercase-font txt-light block">Loans</span>
                                </div>
                                <div class="col-xs-4 text-center  pl-0 pr-0 data-wrap-right">
                                   <i class="zmdi zmdi-file txt-light data-right-rep-icon"></i>
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
              <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default card-view">
                 <div class="panel-heading">
                    <div class="pull-left">
                       <h6 class="panel-title txt-dark">SMS Outbox Statistics</h6>
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
              
           <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                   <div class="panel panel-default card-view panel-refresh">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading">
                    <div class="pull-left">
                       <h6 class="panel-title txt-dark">Traffic Stats</h6>
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
                             <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">44.46% organic</span><span class="block txt-grey">356 visits</span></span>
                             <div id="sparkline_1" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"></div>
                             <div class="clearfix"></div>
                          </div>
                       </div>
                       <hr class="light-grey-hr row mt-10 mb-15"/>
                       <div class="label-chatrs">
                          <div class="">
                             <span class="clabels clabels-lg inline-block bg-green mr-10 pull-left"></span>
                             <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">5.54% Refrral</span><span class="block txt-grey">36 visits</span></span>
                             <div id="sparkline_2" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"></div>
                             <div class="clearfix"></div>
                          </div>
                       </div>
                       <hr class="light-grey-hr row mt-10 mb-15"/>
                       <div class="label-chatrs">
                          <div class="">
                             <span class="clabels clabels-lg inline-block bg-yellow mr-10 pull-left"></span>
                             <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">50% Other</span><span class="block txt-grey">245 visits</span></span>
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
                                      <th>Campaign</th>
                                      <th>Client</th>
                                      <th>Changes</th>
                                      <th>Budget</th>
                                      <th>Status</th>
                                   </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                      <td><span class="txt-dark weight-500">Facebook</span></td>
                                      <td>Beavis</td>
                                      <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>2.43%</span></span></td>
                                      <td>
                                         <span class="txt-dark weight-500">$1478</span>
                                      </td>
                                      <td>
                                         <span class="label label-primary">Active</span>
                                      </td>
                                   </tr>
                                   <tr>
                                      <td><span class="txt-dark weight-500">Youtube</span></td>
                                      <td>Felix</td>
                                      <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>1.43%</span></span></td>
                                      <td>
                                         <span class="txt-dark weight-500">$951</span>
                                      </td>
                                      <td>
                                         <span class="label label-danger">Closed</span>
                                      </td>
                                   </tr>
                                   <tr>
                                      <td><span class="txt-dark weight-500">Twitter</span></td>
                                      <td>Cannibus</td>
                                      <td><span class="txt-danger"><i class="zmdi zmdi-caret-down mr-10 font-20"></i><span>-8.43%</span></span></td>
                                      <td>
                                         <span class="txt-dark weight-500">$632</span>
                                      </td>
                                      <td>
                                         <span class="label label-default">Hold</span>
                                      </td>
                                   </tr>
                                   <tr>
                                      <td><span class="txt-dark weight-500">Spotify</span></td>
                                      <td>Neosoft</td>
                                      <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>7.43%</span></span></td>
                                      <td>
                                         <span class="txt-dark weight-500">$325</span>
                                      </td>
                                      <td>
                                         <span class="label label-default">Hold</span>
                                      </td>
                                   </tr>
                                   <tr>
                                      <td><span class="txt-dark weight-500">Instagram</span></td>
                                      <td>Hencework</td>
                                      <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>9.43%</span></span></td>
                                      <td>
                                         <span class="txt-dark weight-500">$258</span>
                                      </td>
                                      <td>
                                         <span class="label label-primary">Active</span>
                                      </td>
                                   </tr>
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
                       <h6 class="panel-title txt-dark">Advertising & Promotions</h6>
                    </div>
                    <div class="pull-right">
                       <a href="#" class="pull-left inline-block refresh mr-15">
                          <i class="zmdi zmdi-replay"></i>
                       </a>
                       <div class="pull-left inline-block dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                          <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>option 1</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>option 2</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>option 3</a></li>
                          </ul>
                       </div>
                    </div>
                    <div class="clearfix"></div>
                 </div>
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                       <div>
                          <canvas id="chart_2" height="253"></canvas>
                       </div>   
                       <div class="label-chatrs mt-30">
                          <div class="inline-block mr-15">
                             <span class="clabels inline-block bg-yellow mr-5"></span>
                             <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Active</span>
                          </div>
                          <div class="inline-block mr-15">
                             <span class="clabels inline-block bg-red mr-5"></span>
                             <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Closed</span>
                          </div>   
                          <div class="inline-block">
                             <span class="clabels inline-block bg-green mr-5"></span>
                             <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Hold</span>
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
