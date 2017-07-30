@extends('layouts.master')

@section('title')

    Create Bulk Accounts

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')
    
    <div class="container-fluid">

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">
                
                <div  class="col-sm-12 col-md-8 col-md-offset-2">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">
                        
                        <div class="panel panel-default card-view">
                           
                           <div class="panel-wrapper collapse in">
                              
                              <div class="panel-body">               

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Create Bulk Accounts</h3>
                                 </div>   

                                 <hr>

                                 <div class="form-wrap">
                                    
                                    <form class="form-horizontal" method="POST" 
                                        enctype="multipart/form-data" action="{{ route('bulk-users.store') }}">
                                       
                                       {{ csrf_field() }}

                                       @if (count($errors))
                                         <div class="alert alert-danger text-center">
                                             <ul class="list-icons mb-20">
                                                 @foreach ($errors->all() as $error)                                          
                                                    <li> 
                                                      <i class="fa fa-genderless text-white mr-5"></i>
                                                      {!! $error !!}
                                                    </li>
                                                 @endforeach
                                             </ul>
                                         </div>
                                       @endif
                                       
                                       <div  
                                          class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}"
                                          v-show="{{ (Auth::user()->hasRole('superadministrator')) }}">
                                              
                                          <label for="company_id" class="col-sm-3 control-label">
                                             Company Name
                                             <span class="text-danger"> *</span>
                                          </label> 
                                          <div class="col-sm-9">
                                            
                                             <select class="selectpicker form-control" 
                                                name="company_id" 
                                                data-style="form-control btn-default btn-outline"
                                                required>
                                           
                                                @foreach ($companies as $company)
                                                <li class="mb-10">
                                                    <option value="{{ $company->id }}">
                                                      {{ $company->name }}
                                                    </option>
                                                </li>
                                                @endforeach
                                                
                                             </select>

                                             @if ($errors->has('company_name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('company_name') }}</strong>
                                                  </span>
                                             @endif
                                          
                                          </div>

                                       </div>

                                       <div class="form-group">
                                         <label class="col-sm-3 control-label">
                                            Select Source File (XLS, XLSX, CSV)
                                         </label>
                                         <div class="col-sm-9">
                                           <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                              <div class="form-control" data-trigger="fileinput"> 
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i> 
                                                <span class="fileinput-filename"></span>
                                              </div>
                                              <span class="input-group-addon fileupload btn btn-info btn-anim btn-file">
                                                <i class="fa fa-upload"></i> 
                                                <span class="fileinput-new btn-text">Select file</span> 
                                                <span class="fileinput-exists btn-text">Change</span>
                                                <input type="file" name="import_file">
                                              </span> 
                                              <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput">
                                                <i class="fa fa-trash"></i>
                                                <span class="btn-text"> Remove</span>
                                              </a> 
                                           </div>
                                         </div>
                                      </div>

                                       <br/>

                                       <div class="form-group">
                                          <div class="col-sm-3"></div>
                                          <div class="col-sm-9">
                                             <button type="submit" class="btn btn-primary btn-block mr-10">Submit</button>
                                          </div>
                                       </div>

                                       <br/>

                                       <hr>

                                       <div class="text-center">
                                          <a href="{{ route('users.create') }}">
                                          <i class="zmdi zmdi-account-add mr-10"></i> Create Single Account
                                          </a>
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
          </div>
       </div>
       <!-- /Row -->
        

    </div>
         

@endsection


@section('page_scripts')

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
  
@endsection
