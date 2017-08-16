@extends('layouts.master')

@section('title')

    Manage Accounts

@endsection


@section('content')
    
    <div class="container-fluid">
        
		   <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
          <h5 class="txt-dark">
                Manage Accounts 
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('accounts') !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

       <!-- Row -->
        <div class="row mt-15">

           @include('layouts.partials.error_text')
           
           <div class="col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                 
                 @if (!count($accounts))

                    <div class="alert alert-danger text-center">
                      No records found
                    </div>

                 @else

                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading panel-heading-dark">
                    <div class="pull-left">
                                                   
                        <a 
                          href="{{ route('accounts.create') }}" 
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
                      
                      <form action="">
                       <table>
                         <tr>
                            <td>
                              Search
                            </td>
                            <td>
                              <input 
                                  type="text" 
                                  class="form-control input-sm" 
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
                                        <th width="20%">Member Name</th>
                                        <th width="15%">Account Number</th>
                                        <th width="15%">Account Bal (Ksh)</th>
                                        <th width="15%">Group</th>
                                        <th width="15%">Created</th>
                                        <th width="15%">Actions</th>
                                     </tr>
                                  </thead>
                                  <tbody>

                                     @foreach ($accounts as $account)                                   
  	                                   <tr>

  	                                      <td>
  	                                      	<span class="txt-dark weight-500">
  	                                      		{{ $account->id }}
  	                                      	</span>
  	                                      </td>

                                          <td>
                                            <span class="txt-dark weight-500">
                                              {{ $account->user->first_name }}
                                                &nbsp;
                                              {{ $account->user->last_name }}
                                            </span>
                                          </td>

                                          <td>
                                            <span class="txt-dark weight-500">
                                              {{ $account->account_number }}
                                            </span>
                                          </td>

                                          <td>
                                            <span class="txt-dark weight-500">
                                              {{ format_num($account->account_balance, 0) }}
                                            </span>
                                          </td>

                                          

                                          <td>
                                            <span class="txt-dark weight-500">
                                              {{ $account->user->group->name }}
                                            </span>
                                          </td>

  	                                      <td>
                                             <span class="txt-dark weight-500">
                                             {{ formatFriendlyDate($account->created_at) }}
                                             </span>
                                          </td>
                                          
  	                                      <td>

                								             <a href="{{ route('accounts.show', $account->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                              <i class="zmdi zmdi-eye"></i> 
                                             </a>

                                             <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                              <i class="zmdi zmdi-edit"></i> 
                                             </a>

                								             <a href="{{ route('accounts.destroy', $account->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
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
							             {{ $accounts->links() }}
                       </div>   
                    </div>   
                 </div>

                 @endif

              </div>
           </div>

        </div>   
        <!-- Row -->

    </div>
         

@endsection
