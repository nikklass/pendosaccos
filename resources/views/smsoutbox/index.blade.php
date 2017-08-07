@extends('layouts.master')

@section('title')

    Manage SMS Outbox

@endsection


@section('content')
    
    <div class="container-fluid">

		   <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Manage SMS Outbox</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
	            
              {!! Breadcrumbs::render('smsoutbox') !!}

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
        <div class="row">
           <div class="col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading panel-heading-dark">
                    
                    <div class="pull-left">
                       
                       <a 
                          href="{{ route('smsoutbox.create') }}" 
                          class="btn btn-sm btn-primary  btn-icon right-icon mr-5">
                          <span>New</span>
                          <i class="fa fa-plus"></i>
                        </a>

                        <div class="btn-group">
                            <div class="dropdown">
                               <button 
                                  aria-expanded="false" 
                                  data-toggle="dropdown" 
                                  class="btn btn-sm btn-success  dropdown-toggle " 
                                  type="button">
                                  Download 
                                  <span class="caret ml-10"></span>
                               </button>
                               <ul role="menu" class="dropdown-menu">
                                  <li><a href="{{ route('excel.export-smsoutbox', 'xls') }}">As Excel</a></li>
                                  <li><a href="{{ route('excel.export-smsoutbox', 'csv') }}">As CSV</a></li>
                                  <li><a href="{{ route('excel.export-smsoutbox', 'pdf') }}">As PDF</a></li>
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

                                      <th width="5%">id</th>
                                      <th width="40%">Message</th>
                                      <th width="15%">Phone</th>
                                      <th width="10%">Status</th>

                                      @if (Auth::user()->hasRole('superadministrator'))
                                        <th width="10%">Company</th>
                                        <th width="10%">Bulk SMS Name</th>
                                      @endif

                                      <th width="15%">Created</th>
                                      <th width="15%">Actions</th>

                                   </tr>

                                </thead>
                                <tbody>

                                   @foreach ($smsoutboxes as $smsoutbox)                                   
	                                   <tr>
	                                      <td>
	                                      	<span class="txt-dark weight-500">
	                                      		{{ $smsoutbox->id }}
	                                      	</span>
	                                      </td>
	                                      <td>
                                          <span class="txt-dark weight-500">
                                            {{ $smsoutbox->message }}
                                          </span>
                                        </td>
	                                      <td>
                                           <span class="txt-dark weight-500">
                                            {{ $smsoutbox->phone_number }}
                                           </span>
                                        </td>
                                        <td>
                                           <span class="txt-dark weight-500">
                                            {{ $smsoutbox->status->name }}
                                           </span>
                                        </td>

                                        @if (Auth::user()->hasRole('superadministrator'))
                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ $smsoutbox->company->name }}
                                              </span>
                                            </td>
                                            <td>
                                              <span class="txt-dark weight-500">
                                                @if ($smsoutbox->company)
                                                {{ $smsoutbox->company->sms_user_name }}
                                                @endif
                                              </span>
                                            </td>
                                        @endif

	                                      <td>
	                                         <span class="txt-dark weight-500">
                                              {{ formatFriendlyDate($smsoutbox->created_at) }}
	                                         </span>
	                                      </td>
	                                      <td>

              								             <a href="{{ route('smsoutbox.show', $smsoutbox->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                            <i class="zmdi zmdi-eye"></i> 
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
							             {{ $smsoutboxes->links() }}
                       </div>   
                    </div>   
                 </div>
              </div>
           </div>

        </div>   
        <!-- Row -->

    </div>
         

@endsection
