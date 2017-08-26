<form action="{{ route('deposits.index') }}">
 <table class="table table-search">
   <tr>
      
      <td>
        <input type="hidden" value="1" name="search">
        
        <div class='input-group date' id='start_at_group'>
            <input 
                type='text' 
                class="form-control" 
                placeholder="Start Date" 
                id='start_at'
                name="start_at" 
                
                @if (app('request')->input('start_at'))
                    value="{{ app('request')->input('start_at') }}"
                @endif

            />
            <span class="input-group-addon">
               <span class="fa fa-calendar"></span>
            </span>
         </div>

      </td>

      <td>
        
        <div class='input-group date' id='end_at_group'>
            <input 
                type='text' 
                class="form-control" 
                placeholder="End Date" 
                id='end_at'
                name="end_at" 
                
                @if (app('request')->input('end_at'))
                    value="{{ app('request')->input('end_at') }}"
                @endif

            />
            <span class="input-group-addon">
               <span class="fa fa-calendar"></span>
            </span>
         </div>

      </td>

      <td>
        
          <a class="btn btn-default btn-icon-anim btn-circle" 
          data-toggle="tooltip" data-placement="top"
          title="Clear dates" id="clear_date">
            <i class="zmdi zmdi-chart-donut"></i>
          </a>

      </td>
      
      <td>

        <select class="selectpicker form-control" name="user_id" 
          data-style="form-control btn-default btn-outline">

            <li class="mb-10"><option value="">Select User</option></li>

            @foreach ($users as $user) 
              <li class="mb-10">
                
                <option value="{{ $user->id }}"

                    @if ($user->id == app('request')->input('user_id'))
                        selected="selected"
                    @endif

                  >

                  {{ $user->first_name }} 
                  {{ $user->last_name }}

                </option>

              </li>
            @endforeach

         </select>
        
      </td>
      <td>
        <button class="btn btn-primary">Filter</button>
      </td>
   </tr>
 </table>
</form>