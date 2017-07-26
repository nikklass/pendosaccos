@extends('layouts.master')

@section('title')

    Users

@endsection


@section('content')
    
    <div class="container-fluid">
        
		<!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Manage Users</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
	            <a href="{{ route('users.create') }}" class="btn btn-primary btn-icon right-icon pull-right">
	            	<span>Create New User</span> 
	            	<i class="zmdi zmdi-account-add"></i> 
	            </a>
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

       <!-- Row -->
        <div class="row">
           <div class="col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading panel-heading-dark">
                    <div class="pull-left">
                       <h6 class="panel-title txt-dark"></h6>
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
                                      <th>id</th>
                                      <th>Full Names</th>
                                      <th>Email</th>
                                      <th>Created</th>
                                      <th>Actions</th>
                                   </tr>
                                </thead>
                                <tbody>

                                   @foreach ($users as $user)                                   
	                                   <tr>
	                                      <td>
	                                      	<span class="txt-dark weight-500">
	                                      		{{ $user->id }}
	                                      	</span>
	                                      </td>
	                                      <td>
	                                      	<span class="txt-dark weight-500">
	                                      		{{ $user->first_name }} &nbsp; {{ $user->last_name }}
	                                      	</span>
	                                      </td>
	                                      <td>
	                                         <span class="txt-dark weight-500">
	                                         	{{ $user->email }}
	                                         </span>
	                                      </td>
	                                      <td>
	                                         <span class="txt-dark weight-500">
	                                         	{{ $user->created_at->toFormattedDateString() }}
	                                         </span>
	                                      </td>
	                                      <td>
	                                         <!-- <span class="label label-primary">Active</span> -->
	                                         <!-- <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline btn-primary btn-icon right-icon pull-right">
								            	<span>Edit</span> 
								            	<i class="zmdi zmdi-account-add"></i> 
								             </a> -->

								             <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
								             	<i class="zmdi zmdi-edit"></i> 
								             </a>

								             <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
								             	<i class="zmdi zmdi-delete"></i> 
								             </a>

	                                      </td>
	                                   </tr>
                                   @endforeach 
                                   
                                </tbody>
                             </table>
                          </div>
                       </div>
                       <hr>
                       <div class="text-center">
							{{ $users->links() }}
                       </div>   
                    </div>   
                 </div>
              </div>
           </div>

           <!-- <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading">
                    <div class="pull-left">
                       <h6 class="panel-title txt-dark">User Statistics</h6>
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
           </div>   -->

        </div>   
        <!-- Row -->

    
       <!-- Row -->
       <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-default card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-dark">default panel</h6>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-default card-view panel-refresh">
                <div class="refresh-container">
                   <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-dark">Panel with action</h6>
                   </div>
                   <div class="pull-right">
                      <a class="pull-left inline-block mr-15" data-toggle="collapse" href="#collapse_1" aria-expanded="true">
                         <i class="zmdi zmdi-chevron-down"></i>
                         <i class="zmdi zmdi-chevron-up"></i>
                      </a>
                      <div class="pull-left inline-block dropdown mr-15">
                         <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                         <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>option 1</a></li>
                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>option 2</a></li>
                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>option 3</a></li>
                         </ul>
                      </div>
                      <a href="#" class="pull-left inline-block refresh mr-15">
                         <i class="zmdi zmdi-replay"></i>
                      </a>
                      <a href="#" class="pull-left inline-block full-screen mr-15">
                         <i class="zmdi zmdi-fullscreen"></i>
                      </a>
                      <a class="pull-left inline-block close-panel" href="#" data-effect="fadeOut">
                         <i class="zmdi zmdi-close"></i>
                      </a>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  id="collapse_1" class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-default border-panel card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-dark">border panel</h6>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <!-- /Row -->
       
       <!-- Row -->
       <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-default card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-dark">Panel heading<small class="text-muted"> sub heading</small></h6>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-default card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-dark"><i class="zmdi zmdi-lock-outline mr-10"></i>Panel with icons</h6>
                   </div>
                   
                   <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-default card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title inline-block txt-dark">Panel with label</h6>
                   </div>
                   <div class="pull-right">
                      <span class="label label-info capitalize-font inline-block ml-10">label</span>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <!-- /Row -->
       
       <!-- Row -->
       <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-default panel-dropdown card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-dark">panel with dropdown</h6>
                   </div>
                   <div class="pull-right">
                      <div class="dropdown  pull-left">
                         <a class="dropdown-toggle weight-500" id="examplePanelDropdown" data-toggle="dropdown" href="#" aria-expanded="false" role="button">
                            <i class="zmdi zmdi-edit inline-block mr-5"></i>
                            <span>Dropdown</span> 
                            <i class="zmdi zmdi-chevron-down caret-down"></i>
                         </a>
                         <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i> Reply</a></li>
                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i> Share</a></li>
                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i> Delete</a></li>
                            <li class="divider" role="presentation"></li>
                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-settings" aria-hidden="true"></i> Settings</a></li>
                         </ul>
                      </div>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-default card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-dark">Panel with table</h6>
                   </div>
                   
                   <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                   <div  class="panel-body row pa-0">
                      <table class="table table-hover mb-0">
                         <thead>
                            <tr>
                               <th>#</th>
                               <th>First Name</th>
                               <th>Last Name</th>
                            </tr>
                         </thead>
                         <tbody>
                            <tr>
                               <td>1</td>
                               <td>Mark</td>
                               <td>Otto</td>
                            </tr>
                            <tr>
                               <td>2</td>
                               <td>Jacob</td>
                               <td>Thornton</td>
                            </tr>
                            <tr>
                               <td>3</td>
                               <td>Steave</td>
                               <td>Jobs</td>
                            </tr>
                         </tbody>
                      </table>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-default panel-tabs card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-dark">Panel with tabs</h6>
                   </div>
                   <div class="pull-right">
                      <div  class="tab-struct custom-tab-1">
                         <ul role="tablist" class="nav nav-tabs" id="myTabs_9">
                            <li class="active" role="presentation"><a aria-expanded="true"  data-toggle="tab" role="tab" id="home_tab_9" href="#home_9">active</a></li>
                            <li role="presentation" class=""><a  data-toggle="tab" id="profile_tab_9" role="tab" href="#profile_9" aria-expanded="false">inactive</a></li>
                         </ul>
                      </div>   
                   </div>
                   
                   <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                   <div class="panel-body">
                      <div class="tab-content" id="myTabContent_9">
                         <div  id="home_9" class="tab-pane fade active in" role="tabpanel">
                            <p>Lorem ipsum dolor sit amet, et pertinax ocurreret scribentur sit, eum euripidis assentior ei. In qui quodsi maiorum, dicta clita duo ut. Fugit sonet quo te.</p>
                         </div>
                         <div id="profile_9" class="tab-pane fade" role="tabpanel">
                            <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee.</p>
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
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-info card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-light">panel info</h6>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-warning card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-light">panel warning</h6>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-danger card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-light">panel danger</h6>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
       
       </div>
       <!-- /Row -->
       
       <!-- Row -->
       <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-success card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-light">panel success</h6>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-primary card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title txt-light">panel primary</h6>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <div class="panel panel-inverse card-view">
                <div class="panel-heading">
                   <div class="pull-left">
                      <h6 class="panel-title">panel inverse</h6>
                   </div>
                   <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                   </div>
                </div>
             </div>
          </div>
       
       </div>
       <!-- /Row -->
       
       <!-- Row -->
       <div class="row">
          <div class="col-lg-4">
             <div class="well card-view">
                <h6 class="mb-15">Normal Well</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
             </div>
          </div>
          
          <div class="col-lg-4">
             <div class="well well-lg card-view">
                <h6 class="mb-15">Large Well</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
             </div>
          </div>
          
          <div class="col-lg-4">
             <div class="well well-sm card-view">
                <h6 class="mb-15">Small Well</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
             </div>
          </div>
          
       </div>
       <!-- /Row -->

    </div>
         

@endsection
