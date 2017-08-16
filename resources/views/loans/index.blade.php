@extends('layouts.master')

@section('title')

    Manage Loans

@endsection


@section('content')
    
    <div class="container-fluid">
        
		   <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
          <h5 class="txt-dark">
                Manage Loans 
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('loans') !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

       <!-- Row -->
        <div class="row mt-15">

           @if (!count($loans)) 

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
                              href="{{ route('loans.create') }}" 
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
                          
                          <form action="{{ route('loans.index') }}">
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
                                          <th width="10%" class="text-right">Amount (Ksh)</th>
                                          <th width="10%" class="text-right">Paid (Ksh)</th>
                                          <th width="15%">Member Name</th>

                                          @if (Auth::user()->hasRole('superadministrator'))
                                            <th width="10%">Group</th>
                                          @endif

                                          <th width="10%">Created By</th>
                                          <th width="15%">Created At</th>
                                          <th width="15%">Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($loans as $loan)                                   
    	                                   <tr>

    	                                      <td>
    	                                      	<span class="txt-dark weight-500">
    	                                      		{{ $loan->id }}
    	                                      	</span>
    	                                      </td>

                                            <td align="right">
                                              <span class="txt-dark weight-500">
                                                {{ format_num($loan->loan_amount, 0) }}
                                              </span>
                                            </td>

                                            <td align="right">
                                              <span class="txt-dark weight-500">
                                                {{ format_num($loan->paid_amount, 0) }}
                                              </span>
                                            </td>

                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ $loan->user->first_name }}
                                                  &nbsp;
                                                {{ $loan->user->last_name }}
                                              </span>
                                            </td>

                                            <td>
                                              <span class="txt-dark weight-500">
                                                @if (Auth::user()->hasRole('superadministrator'))
                                                  {{ $loan->user->group->name }}
                                                @endif
                                              </span>
                                            </td>

                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ $loan->creator->first_name }}
                                              </span>
                                            </td>

    	                                      <td>
                                               <span class="txt-dark weight-500">
                                               {{ formatFriendlyDate($loan->created_at) }}
                                               </span>
                                            </td>
                                            
    	                                      <td>

                  								             <a href="{{ route('loans.show', $loan->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square" 
                                               data-toggle="tooltip" 
                                               title="View loan id: {{ $loan->id }}">
                                                <i class="zmdi zmdi-eye"></i> 
                                               </a>

                                               <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square" 
                                               data-toggle="tooltip"
                                               title="Edit loan id: {{ $loan->id }}">
                                                <i class="zmdi zmdi-edit"></i> 
                                               </a>

                  								             <a href="{{ route('loans.destroy', $loan->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square" 
                                               data-toggle="tooltip"
                                               title="Delete loan id: {{ $loan->id }}">
                                                <i class="zmdi zmdi-delete"></i> 
                                               </a>

                                               <a href="{{ route('repayments.create', 'loan_id='. $loan->id) }}" class="btn btn-success btn-sm btn-icon-anim btn-square"
                                               data-toggle="tooltip"
                                               title="Make repayment for loan id: {{ $loan->id }}">
                                                <i class="zmdi zmdi-money"></i> 
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
    							             {{ $loans->links() }}
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
