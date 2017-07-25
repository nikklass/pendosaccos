@extends('layouts.master')

@section('title')

    Showing Company - {{ $company->name }}

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
                       
                      <h5 class="block mt-10 mb-5 weight-500 capitalize-font">
                          Company name: <span class="txt-danger">{{ $company->name }}</span>
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
                                            <strong>Company Name:</strong> 
                                            {{ $company->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Email:</strong>  
                                            {{ $company->email }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Phone:</strong> 
                                            {{ $company->phone_number }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Box Number:</strong> 
                                           {{ $company->box }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Physical Address:</strong> 
                                           {{ $company->physical_address }}
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
                          href="{{ route('companies.edit', $company->id) }}" 
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Company</span>
                      </a>

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
                        <h5>Company Stats</h5>
                    </p>

                    <hr>

                    <div class="row">
                      <div class="col-sm-12">
                          
                          <ul class="list-icons">
                              <li class="mb-10">
                                  <strong>Groups: </strong> 42
                              </li>
                              <li class="mb-10">
                                  <strong>Members: </strong> 265
                              </li>
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

