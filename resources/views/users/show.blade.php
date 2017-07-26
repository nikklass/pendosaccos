@extends('layouts.master')

@section('title')

    Showing {{ $user->first_name }}

@endsection


@section('content')
    

    <div class="container-fluid pt-10">
          
        <!-- Row -->
        <div class="row">

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
                      <div class="profile-image-overlay"></div>
                    </div>
                    <div class="profile-info text-center">
                      <div class="profile-img-wrap">
                        <img class="inline-block mb-10" src="/css/images/nikk.jpg" alt="{{ $user->first_name }}"/>
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
                      <!-- <h6 class="block capitalize-font pb-20">Developer Geek</h6> -->
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
                                           {{ $user->gender }}
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

                      <!-- <div id="myModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                              <h5 class="modal-title" id="myModalLabel">Edit User</h5>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="">
                                    <div class="panel-wrapper collapse in">
                                      <div class="panel-body pa-0">
                                        <div class="col-sm-12 col-xs-12">
                                          <div class="form-wrap">
                                            <form action="#">
                                              <div class="form-body overflow-hide">
                                                <div class="form-group">
                                                  <label class="control-label mb-10" for="exampleInputuname_1">Name</label>
                                                  <div class="input-group">
                                                    <div class="input-group-addon"><i class="icon-user"></i></div>
                                                    <input type="text" class="form-control" id="exampleInputuname_1" placeholder="willard bryant">
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                  <label class="control-label mb-10" for="exampleInputEmail_1">Email address</label>
                                                  <div class="input-group">
                                                    <div class="input-group-addon"><i class="icon-envelope-open"></i></div>
                                                    <input type="email" class="form-control" id="exampleInputEmail_1" placeholder="xyz@gmail.com">
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                  <label class="control-label mb-10" for="exampleInputContact_1">Contact number</label>
                                                  <div class="input-group">
                                                    <div class="input-group-addon"><i class="icon-phone"></i></div>
                                                    <input type="email" class="form-control" id="exampleInputContact_1" placeholder="+102 9388333">
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                  <label class="control-label mb-10" for="exampleInputpwd_1">Password</label>
                                                  <div class="input-group">
                                                    <div class="input-group-addon"><i class="icon-lock"></i></div>
                                                    <input type="password" class="form-control" id="exampleInputpwd_1" placeholder="Enter pwd" value="password">
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                  <label class="control-label mb-10">Gender</label>
                                                  <div>
                                                    <div class="radio">
                                                      <input type="radio" name="radio1" id="radio_1" value="option1" checked="">
                                                      <label for="radio_1">
                                                      M
                                                      </label>
                                                    </div>
                                                    <div class="radio">
                                                      <input type="radio" name="radio1" id="radio_2" value="option2">
                                                      <label for="radio_2">
                                                      F
                                                      </label>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                  <label class="control-label mb-10">Country</label>
                                                  <select class="form-control" data-placeholder="Choose a Category" tabindex="1">
                                                    <option value="Category 1">USA</option>
                                                    <option value="Category 2">Austrailia</option>
                                                    <option value="Category 3">India</option>
                                                    <option value="Category 4">UK</option>
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="form-actions mt-10">      
                                                <button type="submit" class="btn btn-success mr-10 mb-30">Update profile</button>
                                              </div>        
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">Save</button>
                              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                            </div>
                          </div>
                        </div>
                      </div> -->

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-xs-12">
            <div class="panel panel-default card-view pa-0">
              <div class="panel-wrapper collapse in">
                <div  class="panel-body pb-0 ml-20 mr-20">
                    
                    <p class="mb-20">
                        <h5>User Roles</h5>
                    </p>

                    <hr>

                    <div class="row">
                      <div class="col-sm-12">
                        
                          <p class="mb-20">
                            {{ $user->roles->count() == 0 ? 'This user has no assigned role yet' : '' }}
                          </p>

                          <ul class="list-icons">
                              @foreach ($user->roles as $role)
                              <li class="mb-10">
                                  <i class="fa fa-genderless text-success mr-5"></i>
                                  {{ $role->display_name }} 
                                  <em class="ml-15"> ({{ $role->description }})</em>
                              </li>
                              @endforeach
                          </ul>

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

