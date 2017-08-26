@extends('layouts.master')

@section('title')

    Displaying Group - {{ $group->name }}

@endsection


@section('content')
    

    <div class="container-fluid pt-10">
          
        <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying Group - {{ $group->name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              
              {!! Breadcrumbs::render('groups.show', $group->id) !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

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
                       
                      <h5 class="block mt-10 mb-5 weight-500 capitalize-font">
                          Group name: <span class="txt-danger">{{ $group->name }}</span>
                      </h5>
                      <!-- <h6 class="block capitalize-font pb-20">Nikk</h6> -->
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
                                            <strong>Group Description:</strong> 
                                            {{ $group->description }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Email:</strong>  
                                            {{ $group->email }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Phone:</strong> 
                                            {{ $group->phone_number }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Box Number:</strong> 
                                           {{ $group->box }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Physical Address:</strong> 
                                           {{ $group->physical_address }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created:</strong> 
                                           {{ formatFriendlyDate($group->created_at) }}
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
                          href="{{ route('groups.edit', $group->id) }}" 
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Group</span>
                      </a>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-xs-12">

            <div class="panel panel-default card-view pa-0">
              
              <div  class="panel-wrapper collapse in">
                 
                 <div  class="panel-body pb-0 ml-20 mr-20">
                    
                      <p class="mb-20">
                          <h5>Group Account Balance</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-sm-12">
                                                            
                            <h3 class="text-left text-success mb-20">
                              {{ formatCurrency($group->account_balance) }}
                            </h3> 

                        </div>
                      </div>

                 </div>

              </div>

            </div>

            <div class="panel panel-default card-view pa-0">
              
              <div  class="panel-wrapper collapse in">
                 
                 <div  class="panel-body pb-0 ml-20 mr-20">
                    
                      <p class="mb-20">
                          <h5>Group Loans</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-sm-12">
                                
                            <h3 class="text-left text-primary mb-20">

                             {{ formatCurrency($groups_loans->loan_balance) }}
                            </h3> 

                        </div>
                      </div>

                 </div>

              </div>

            </div>

            <div class="panel panel-default card-view pa-0">
              
              <div  class="panel-wrapper collapse in">

                <div  class="panel-body pb-0 ml-20 mr-20">
                    
                      <p class="mb-20">
                          <h5>Group Members ({{$users->total()}})</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-sm-12">
                          
                            @if (count($users))

                              <table class="table">
                                        
                                  <thead>

                                      <tr>
                                          <th width="10%">ID</th>
                                          <th width="25%">Full Names</th>
                                          <th class="text-right" width="25%">Balance</th>
                                          <th width="30%">Created At</th>
                                          <th width="10%"></th>
                                      </tr>

                                  </thead>
                              
                                  <tbody>
                                      
                                      @foreach ($users as $user_account)

                                        <tr>

                                          <td>
                                            {{ $user_account->user->id }}
                                          </td>

                                          <td>
                                             <a href="{{ route('member-accounts.show', $user_account->user->id) }}" class="btn-link">
                                               {{ $user_account->user->first_name }} 
                                               {{ $user_account->user->last_name }} 
                                                <em>({{ $user_account->role->display_name }})</em>
                                             </a>
                                          </td>
                                          
                                          <td align="right" class="text-success">
                                            {{ format_num($user_account->account_balance) }}
                                          </td>

                                          <td>
                                            {{ formatFriendlyDate($user_account->created_at) }}
                                          </td>

                                          <td>
                                            <a href="{{ route('member-accounts.show', $user_account->user->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                  <i class="zmdi zmdi-eye"></i> 
                                                 </a>
                                          </td>

                                        </tr>
                                        
                                      @endforeach

                                      <tr>
                                        <td colspan="5">
                                          <div class="text-center mt-20">
                                             {{ $users->links() }}
                                          </div> 
                                        </td>
                                      </tr>
                                      
                                  </tbody>

                              </table>

                            @else
                              
                              <p class="mb-20">
                                Group has no members
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

