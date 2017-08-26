@extends('layouts.master')

@section('title')

    Manage Groups

@endsection


@section('content')
    
    <div class="container-fluid">
        
		<!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
          <h5 class="txt-dark">
                Manage Groups 
                @if ((!Auth::user()->hasRole('superadministrator')) && $user->group)
                  &nbsp; - &nbsp; ({{ $user->group->name }})</th>
                @endif
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
	            
              {!! Breadcrumbs::render('groups') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

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
                          href="{{ route('groups.create') }}" 
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
                                  <li><a href="{{ route('excel.export-groups', 'xls') }}">As Excel</a></li>
                                  <li><a href="{{ route('excel.export-groups', 'csv') }}">As CSV</a></li>
                                  <li><a href="{{ route('excel.export-groups', 'pdf') }}">As PDF</a></li>
                                  <!-- <li class="divider"></li>
                                  <li><a href="#">Separated link</a></li> -->
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
                          
                          <a 
                            class="dropdown-toggle" 
                            data-toggle="dropdown" 
                            href="#" 
                            aria-expanded="false" 
                            role="button">
                            <i class="zmdi zmdi-more-vert"></i>
                          </a>

                          <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                             
                             <li role="presentation">
                                <a href="{{ route('groups.create') }}" role="menuitem">
                                  <i class="icon wb-reply" aria-hidden="true"></i>
                                  New
                                </a>
                             </li>

                             <li role="presentation">
                                <a href="{{ route('groups.create') }}" role="menuitem">
                                  <i class="icon wb-share" aria-hidden="true"></i>
                                  Download
                                </a>
                             </li>

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
                                      <th width="20%">Group Name</th>
                                      <th width="15%" class="text-right">Acct. Bal (Ksh)</th>
                                      <th width="10%">Members</th>
                                      <th width="10%">Phone</th>
                                      <th width="15%">Email</th>
                                      <th width="15%">Created</th>
                                      <th width="15%">Actions</th>
                                   </tr>
                                </thead>
                                <tbody>

                                   @foreach ($groups as $group)                                   
	                                   <tr>
	                                      
	                                      <td>
                                          <span class="txt-dark weight-500">
                                            {{ $group->display_name }}
                                          </span>
                                        </td>

                                        <td align="right">
                                          <span class="txt-dark weight-500">
                                            {{ format_num($group->account_balance) }}
                                          </span>
                                        </td>

                                        <td>
                                          <span class="txt-dark weight-500">
                                            {{ format_num(count($group->users), 0) }}
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
                                           {{ formatFriendlyDate($group->created_at) }}
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
                       <div class="text-center mb-15">
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
