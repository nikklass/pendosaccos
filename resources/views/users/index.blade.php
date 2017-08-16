@extends('layouts.master')

@section('title')

    Manage Members

@endsection


@section('content')
    
    <div class="container-fluid">
        
		<!-- Title -->
       <div class="row heading-bg">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <h5 class="txt-dark">
                Manage Members 
                @if ((!Auth::user()->hasRole('superadministrator')) && $user->group)
                  &nbsp; - &nbsp; ({{ $user->group->name }})</th>
                @endif
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-md-6 col-xs-12">
	            
              {!! Breadcrumbs::render('users') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title --> 

      
      @if (session('success'))
        <div class="row">
          <div class="col-sm-12 col-xs-12">
            <div class="alert alert-success text-center">
                {!! session('success') !!}
            </div>
          </div>
        </div>
      @endif

       <!-- Row -->
        <div class="row mt-15">
           <div class="col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading panel-heading-dark">
                    <div class="pull-left">
                                                   
                        <a 
                          href="{{ route('users.create') }}" 
                          class="btn btn-sm btn-primary btn-icon right-icon mr-5">
                          <span>New</span>
                          <i class="fa fa-plus"></i>
                        </a>

                        <div class="btn-group">
                            <div class="dropdown">
                               <button 
                                  aria-expanded="false" 
                                  data-toggle="dropdown" 
                                  class="btn btn-sm btn-success dropdown-toggle " 
                                  type="button">
                                  Download 
                                  <span class="caret ml-10"></span>
                               </button>
                               <ul role="menu" class="dropdown-menu">
                                  <li><a href="#">As Excel</a></li>
                                  <li><a href="#">As CSV</a></li>
                                  <li><a href="#">As PDF</a></li>
                               </ul>
                            </div>
                        </div>

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
                                      <th width="15%">Full Names</th>
                                      <th width="10%">Account No</th>
                                      <th width="10%" class="text-right">Account Bal</th>
                                      <th width="10%">Roles</th>
                                      
                                      @if (Auth::user()->hasRole('superadministrator'))
                                      <th width="10%">Group</th>
                                      @endif
                                      
                                      <th width="10%">Phone</th>
                                      <th width="15%">Created</th>
                                      <th width="15%">Actions</th>
                                   </tr>
                                </thead>
                                <tbody>

                                   @foreach ($users as $user)                                   
	                                   <tr>
	                                      <td>
                                          <span class="txt-dark weight-500">
                                            {{ $user->first_name }} &nbsp; {{ $user->last_name }}
                                          </span>
                                        </td>
                                        <td>
                                          <span class="txt-dark weight-500">
                                            {{ $user->account_number }}
                                          </span>
                                        </td>
                                        <td class="text-right">
                                          <span class="txt-dark weight-500">
                                            {{ format_num($user->account_balance, 2) }}
                                          </span>
                                        </td>
	                                      
                                        <td>
                                          <span class="txt-dark weight-500">
                                              @foreach ($user->roles as $role) 
                                                <span>{{ $role->name }}</span>
                                              @endforeach
                                          </span>
                                        </td>
                                        
                                        @if (Auth::user()->hasRole('superadministrator'))
                                          
                                          <td>
                                            @if ($user->group)
                                            <span class="txt-dark weight-500">
                                                {{ $user->group->name }}
                                            </span>
                                            @endif
                                          </td>
                                        
                                        @endif

	                                      <td>
                                           <span class="txt-dark weight-500">
                                            {{ $user->phone_number }}
                                           </span>
                                        </td>
                                        
	                                      <td>
	                                         <span class="txt-dark weight-500">
                                           {{ formatFriendlyDate($user->created_at) }}
                                           </span>
	                                      </td>
	                                      <td>
	                                       

								             <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                              <i class="zmdi zmdi-eye"></i> 
                             </a>

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

        </div>   
        <!-- Row -->

    </div>
         

@endsection
