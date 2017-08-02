@extends('layouts.master')

@section('title')

    Manage Groups

@endsection


@section('content')
    
    <div class="container-fluid">
        
		<!-- Title -->
       <div class="row heading-bg">
          <div class="ol-md-6 col-sm-6 col-xs-12">
          <h5 class="txt-dark">
                Manage Groups 
                @if ((!Auth::user()->hasRole('superadministrator')) && $user->company)
                  &nbsp; - &nbsp; ({{ $user->company->name }})</th>
                @endif
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="ol-md-6 col-sm-6 col-xs-12">
	            <a href="{{ route('groups.create') }}" class="btn btn-primary btn-icon right-icon pull-right">
	            	<span>Create New Group</span> 
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
                                      <th>Group Name</th>
                                      <th>Company Name</th>
                                      <th>Phone</th>
                                      <th>Email</th>
                                      <th>Created</th>
                                      <th>Actions</th>
                                   </tr>
                                </thead>
                                <tbody>

                                   @foreach ($groups as $group)                                   
	                                   <tr>
	                                      <td>
	                                      	<span class="txt-dark weight-500">
	                                      		{{ $group->id }}
	                                      	</span>
	                                      </td>
	                                      <td>
                                          <span class="txt-dark weight-500">
                                            {{ $group->name }}
                                          </span>
                                        </td>
                                        <td>
                                          <span class="txt-dark weight-500">
                                            {{ $group->company->name }}
                                          </span>
                                        </td>
	                                      <td>
                                           <span class="txt-dark weight-500">
                                            {{ $group->phone_number }}
                                           </span>
                                        </td>
                                        <td>
                                           <span class="txt-dark weight-500">
                                            {{ $group->email }}
                                           </span>
                                        </td>
	                                      <td>
	                                         <span class="txt-dark weight-500">
	                                         	{{ $group->created_at->toFormattedDateString() }}
	                                         </span>
	                                      </td>
	                                      <td>

              								             <a href="{{ route('groups.show', $group->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                            <i class="zmdi zmdi-eye"></i> 
                                           </a>

                                           <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                            <i class="zmdi zmdi-edit"></i> 
                                           </a>

              								             <a href="{{ route('groups.destroy', $group->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
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
							             {{ $groups->links() }}
                       </div>   
                    </div>   
                 </div>
              </div>
           </div>

        </div>   
        <!-- Row -->

    </div>
         

@endsection
