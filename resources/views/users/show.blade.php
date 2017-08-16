@extends('layouts.master')

@section('title')

    Displaying User - {{ $user->first_name }} {{ $user->last_name }}

@endsection


@section('content')
    

    <div class="container-fluid">
        
       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying User - {{ $user->first_name }} {{ $user->last_name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              
              {!! Breadcrumbs::render('users.show', $user->id) !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->
        

        @include('layouts.partials.error_text')
      

        <!-- Row -->
        <div class="row mt-15">

          <div class="col-lg-6 col-xs-12">
            <div class="panel panel-default card-view  pa-0">
              <div class="panel-wrapper collapse in">
                <div class="panel-body  pa-0">
                  <div class="profile-box">
                    <div class="profile-cover-pic">
                      <div class="fileupload btn btn-default">
                        <span class="btn-text">edit</span>
                        <input class="upload" type="file">
                      </div>
                      <div class="profile-image-overlay">
                        <img src="{{ asset('images/mock6.jpg') }}" width="100%" height="100%">
                      </div>
                    </div>
                    <div class="profile-info text-center">
                      <div class="profile-img-wrap">
                        <img class="inline-block mb-10" src="{{ asset('images/no_user.jpg') }}" alt="{{ $user->first_name }}"/>
                        <div class="fileupload btn btn-default">
                          <span class="btn-text">edit</span>
                          <input class="upload" type="file">
                        </div>
                      </div>  
                      <h5 class="block mt-10 mb-5 weight-500 capitalize-font txt-danger">
                          {{ $user->first_name }}
                          &nbsp;
                          {{ $user->last_name }}
                      </h5>

                    </div>  
                    <div class="social-info">
                      <div class="row">
                        
                          <div class="col-lg-12">
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">
                                    
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Name:</strong> 
                                            {{ $user->first_name }}&nbsp;{{ $user->last_name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Email:</strong>  
                                            {{ $user->email }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Phone:</strong> 
                                            {{ $user->phone_number }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                           <strong>Gender:</strong> 
                                           @if ($user->gender == 'm')
                                              Male
                                           @else
                                              Female
                                           @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Created:</strong> 
                                            {{ formatFriendlyDate($user->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                 
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>

                      </div>

                      <a  
                          href="{{ route('users.edit', $user->id) }}" 
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">edit user</span>
                      </a>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-xs-12">
            
            @if (Auth::user()->hasRole('superadministrator'))
            
              @if ($user->group)
              <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                  <div  class="panel-body pb-0 ml-20 mr-20">
                      
                      <p class="mb-20">
                          <h5>group</h5>
                      </p>

                      <hr>

                      <div class="follo-data mb-20">
                        <div class="user-data">
                          <span class="name block capitalize-font">
                             <strong>{{ $user->group->name }}</strong> 
                          </span>
                        </div>
                        <div class="clearfix"></div>
                      </div>

                  </div>
                </div>
              </div>
              @endif

              @if (count($user->roles))
              <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                  <div  class="panel-body pb-0 ml-20 mr-20">
                      
                      <p class="mb-20">
                          <h5>User Roles</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-sm-12">
                          
                            @if ($user->roles)

                              <ul class="list-icons mb-20">
                                  @foreach ($user->roles as $role)
                                    <li class="mt-10">
                                        <i class="fa fa-genderless text-success mr-5"></i>
                                        {{ $role->display_name }} 
                                        <em class="ml-15"> ({{ $role->description }})</em>
                                    </li>
                                  @endforeach
                              </ul>

                            @else
                              
                              <p class="mb-20">
                                No roles assigned
                              </p>

                            @endif

                        </div>
                      </div>

                  </div>
                </div>
              </div>
              @endif
              
            @endif

            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                  <div  class="panel-body pb-0 ml-20 mr-20">
                      
                      <p class="mb-20">
                          <h5>Cash Account</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-sm-12 mb-10">
                          
                            <div class="form-group">
                              <div class="col-sm-4">
                                <p class="form-control-static ">Account Number:</p>
                              </div>
                              <div class="col-sm-8">
                                <p class="form-control-static"> 
                                  {{ $user->account_number }}
                                </p>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-sm-4">
                                <p class="form-control-static ">Account Balance:</p>
                              </div>
                              <div class="col-sm-8">
                                <p class="form-control-static text-success"> 
                                  Ksh 
                                  <strong>
                                    {{ format_num($user->account_balance, 2) }}
                                  </strong>
                                </p>
                              </div>
                            </div>

                        </div>
                      </div>

                  </div>
                </div>
            </div>

              
            <div class="panel panel-default card-view pa-0">
              <div class="panel-wrapper collapse in">
                <div  class="panel-body pb-0 ml-20 mr-20">
                    
                    <p class="mb-20">
                        <h5>Loans</h5>
                    </p>

                    <hr>

                    <div class="row">
                      <div class="col-sm-12">
                        
                          @if ($user->loans)

                            <table class="table">
                                      
                                <thead>

                                    <tr>
                                        <th class="text-right">Amount</th>
                                        <th class="text-right">Paid</th>
                                        <th class="text-right">Int. p.a.</th>
                                        <th class="text-right">Period</th>
                                        <th>Created At</th>
                                        <th></th>
                                    </tr>

                                </thead>
                            
                                <tbody>
                                    
                                    @foreach ($user->loans as $loan)
                                      <tr>
                                        <td align="right">
                                          {{ format_num($loan->loan_amount) }}
                                        </td>
                                        <td align="right">
                                          {{ format_num($loan->paid_amount) }}
                                        </td>
                                        <td align="right">
                                          {{ $loan->interest }}
                                        </td>
                                        <td align="right">
                                          {{ $loan->period }}
                                        </td>
                                        <td>{{ formatFriendlyDate($loan->created_at) }}</td>
                                        <td>
                                          <a href="{{ route('loans.show', $loan->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                <i class="zmdi zmdi-eye"></i> 
                                               </a>
                                        </td>
                                      </tr>
                                    @endforeach

                                    <tr>
                                      <td colspan="5">
                                        <div class="text-center mt-20">
                                           {{ $loans->links() }}
                                        </div> 
                                      </td>
                                    </tr>
                                    
                                </tbody>

                            </table>

                          @else
                            
                            <p class="mb-20">
                              Member has no loans
                            </p>

                          @endif

                      </div>
                    </div>

                </div>
              </div>
            </div>


          </div>
        </div>
        <!-- /Row -->
      
    </div>
         

@endsection

