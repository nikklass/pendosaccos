@extends('layouts.master')

@section('title')

    Manage Withdrawals

@endsection


@section('content')
    
    <div class="container-fluid">
        
		   <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
          <h5 class="txt-dark">
                Manage Withdrawals 
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('withdrawals') !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

       <!-- Row -->
        <div class="row mt-15">

           @if (!count($withdrawals)) 

              <div class="alert alert-danger text-center">
                  No records found
              </div>

           @else

               @include('layouts.partials.error_text')
               
               <div class="col-sm-12 col-xs-12">
                  <div class="panel panel-default card-view panel-refresh">
                     <div class="refresh-container">
                        <div class="la-anim-1"></div>
                     </div>
                     <div class="panel-heading panel-heading-dark">
                        <div class="pull-left">
                                                       
                            <a 
                              href="{{ route('withdrawals.create') }}" 
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
                                      <!-- <li class="divider"></li>
                                      <li><a href="#">Separated link</a></li> -->
                                   </ul>
                                </div>
                            </div>

                        </div>
                        <div class="pull-right">
                          
                          <form action="{{ route('withdrawals.index') }}">
                           <table>
                             <tr>
                                <td>
                                  Search
                                </td>
                                <td>
                                  <input type="hidden" value="1" name="search">
                                  <input 
                                      type="text" 
                                      class="form-control" 
                                      id="search_text" 
                                      name="search_text"
                                      value="{{ old('search_text') }}">
                                </td>
                                <td>
                                  Order By
                                </td>
                                <td>
                                  <select class="selectpicker form-control input-sm" name="search_order" 
                                    data-style="form-control btn-default btn-outline">

                                    <li class="mb-10"><option value="">Select Column</option></li>
                                    <li class="mb-10"><option value="name">Name</option></li>
                                    <li class="mb-10"><option value="amount">Amount</option></li>
                                    <li class="mb-10"><option value="group">Group</option></li>
                                    <li class="mb-10"><option value="created">Created</option></li>

                                 </select>
                                </td>
                                <td>
                                  <button class="btn btn-sm btn-primary">Filter</button>
                                </td>
                             </tr>
                           </table>
                          </form>
                           
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
                                          <th width="5%">id</th>
                                          <th width="10%">Amount (Ksh)</th>
                                          <th width="10%" class="text-right">Before Bal (Ksh)</th>
                                          <th width="10%" class="text-right">After Bal (Ksh)</th>
                                          <th width="15%">Name</th>
                                          
                                          @if (Auth::user()->hasRole('superadministrator'))
                                          <th width="10%">Group</th>
                                          @endif

                                          <th width="10%">Created By</th>
                                          <th width="15%">Created At</th>
                                          <th width="15%">Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($withdrawals as $withdrawal)                                   
    	                                   <tr>

    	                                      <td>
    	                                      	<span class="txt-dark weight-500">
    	                                      		{{ $withdrawal->id }}
    	                                      	</span>
    	                                      </td>

                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ format_num($withdrawal->amount, 0) }}
                                              </span>
                                            </td>

                                            <td align="right">
                                              <span class="txt-dark weight-500">
                                                {{ format_num($withdrawal->before_balance, 0) }}
                                              </span>
                                            </td>

                                            <td align="right">
                                              <span class="txt-dark weight-500">
                                                {{ format_num($withdrawal->after_balance, 0) }}
                                              </span>
                                            </td>

                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ $withdrawal->user->first_name }}
                                                  &nbsp;
                                                {{ $withdrawal->user->last_name }}
                                              </span>
                                            </td>

                                            @if (Auth::user()->hasRole('superadministrator'))
                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ $withdrawal->user->group->name }}
                                              </span>
                                            </td>
                                            @endif

                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ $withdrawal->creator->first_name }}
                                              </span>
                                            </td>

    	                                      <td>
                                               <span class="txt-dark weight-500">
                                               {{ formatFriendlyDate($withdrawal->created_at) }}
                                               </span>
                                            </td>
                                            
    	                                      <td>

                  								             <a href="{{ route('withdrawals.show', $withdrawal->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                <i class="zmdi zmdi-eye"></i> 
                                               </a>

                                               <a href="{{ route('withdrawals.edit', $withdrawal->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                <i class="zmdi zmdi-edit"></i> 
                                               </a>

                  								             <a href="{{ route('withdrawals.destroy', $withdrawal->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
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
    							             {{ $withdrawals->links() }}
                           </div>   
                        </div>   
                     </div>
                  </div>
               </div>

           @endif

        </div>   
        <!-- Row -->

    </div>
         

@endsection
