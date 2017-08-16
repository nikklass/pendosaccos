@extends('layouts.master')


@section('title')

    Edit Withdrawal - {{ $withdrawal->id }}

@endsection


@section('content')
    
    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Edit Withdrawal - {{ $withdrawal->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('withdrawals.edit', $withdrawal->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

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
                                    <h3 class="text-center txt-dark mb-10">
                                        Edit Withdrawal - {{ $withdrawal->id }}
                                    </h3>
                                 </div>   

                                 <hr>

                                 <div class="form-wrap">
                                    
                                    @include('layouts.partials.error_text')

                                    <form class="form-horizontal" method="POST" 
                                        action="{{ route('withdrawals.update', $withdrawal->id) }}"> 

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div class="form-group">
                                          <label class="control-label col-md-3">User</label>
                                          <div class="col-md-9">
                                          
                                            @if ($withdrawal->user->first_name)
                                              <p class="form-control-static"> 
                                                {{ $withdrawal->user->first_name }} 
                                                &nbsp;
                                                {{ $withdrawal->user->last_name }} 
                                              </p>
                                              <input 
                                                  type="hidden" 
                                                  name="user_id"
                                                  value="{{ $withdrawal->user->id }}">
                                            @endif

                                          </div>
                                       </div>

                                       
                                       <div  class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                              
                                          <label for="amount" class="col-sm-3 control-label">
                                             Amount
                                          </label>
                                          <div class="col-sm-9">

                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="amount" 
                                                name="amount"
                                                value="{{ $withdrawal->amount }}">

                                             @if ($errors->has('amount'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('amount') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                        <div  class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                              
                                            <label for="comment" class="col-sm-3 control-label">
                                               Comment
                                            </label>
                                            <div class="col-sm-9">

                                              <textarea 
                                                  rows="6" 
                                                  class="form-control" 
                                                  id="comment" 
                                                  name="comment">{{ $withdrawal->comment }}</textarea>

                                               @if ($errors->has('comment'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('comment') }}</strong>
                                                    </span>
                                               @endif
                                            </div>

                                         </div>


                                       <br/>

                                       <div class="form-group">
                                          <div class="col-sm-3"></div>
                                          <div class="col-sm-9">
                                              <button 
                                                type="submit" 
                                                class="btn btn-lg btn-primary btn-block mr-10"
                                                 id="submit-btn">
                                                 Submit
                                              </button>
                                          </div>
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
