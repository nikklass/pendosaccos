@extends('layouts.master')

@section('title')

    Showing - {{ $permission->display_name }}

@endsection


@section('content')
    
    <div class="container-fluid">
      
      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Permission - {{ $permission->display_name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              <a 
                  href="{{ route('permissions.edit', $role->id) }}" 
                  class="btn btn-primary btn-icon right-icon pull-right">
                <span>Edit Permission</span> 
                <i class="zmdi zmdi-edit"></i> 
              </a>
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell vertical-align-middle auth-form-wrap-inner">
             <div class="auth-form  ml-auto mr-auto no-float">
                <div class="row">
                   <div class="col-sm-12 col-xs-12">
                      
                      <div class="panel panel-default card-view">
                         
                         <div class="panel-wrapper collapse in">
                            
                            <div class="panel-body">               

                               <div class="mb-30">
                                  <h3 class="text-center txt-dark mb-10">

                                    {{ $permission->display_name }}
  
                                  </h3>
                               </div>   

                               <hr>

                               <div class="form-wrap">
                                 
                                  <form > 

                                     <div class="form-group">
                                            
                                        <label for="first_name" class="col-sm-3 control-label">
                                           Display Name
                                        </label>
                                        <div class="col-sm-9">
                                           <pre>{{ $permission->display_name }}</pre>
                                        </div>

                                     </div>

                                     <div class="form-group">
                                            
                                        <label for="last_name" class="col-sm-3 control-label">
                                           Slug
                                        </label>
                                        <div class="col-sm-9">
                                           <pre>{{ $permission->name }}</pre>
                                        </div>

                                     </div>

                                     <div  class="form-group">
                                            
                                        <label for="email" class="col-sm-3 control-label">
                                           Description
                                        </label>
                                        <div class="col-sm-9">
                                           <pre>{{ $permission->description }}</pre>
                                        </div>

                                     </div>


                                     <hr>
                                     
                                  </form>

                               </div>

                            </div>

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

