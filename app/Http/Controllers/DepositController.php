<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Group;
use App\RoleUser;
use App\Services\Deposit\DepositStore;
use App\Services\Deposit\DepositUpdate;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Excel;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;

class DepositController extends Controller
{

    /**
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //set page permissions
        $permissions = array('read-deposit', 'update-deposit', 'delete-deposit');

        //get logged in user
        $auth_user = auth()->user();

        $search = $request->search;
        $search_text = $request->search_text;

        //if user is superadmin, show all deposits and user accounts, 
        //else show deposits as necessary
        $deposits = [];
        $users = [];

        if ($auth_user->hasRole('superadministrator')){
            
            //get deposits
            $deposits = Deposit::with('user');
            //get user accounts
            $users = RoleUser::all();

        } else {
            
            //get current user group/ team ids
            $team_ids = $auth_user->teams->pluck('id');
            $team_ids = $team_ids->unique('id');

            //find current user permissions in above groups/ teams on deposits model??
            $team_ids = getAdminGroupIds($team_ids, $permissions); 

            //get current user's account ids
            $user_account_ids = RoleUser::where('user_id', $auth_user->id)->pluck('id');

            //get group user ids           
            if (count($team_ids)) {

                //get team users deposits
                $deposits = Deposit::whereIn("team_id", $team_ids)
                        ->orWhereIn("user_id", $user_account_ids); 

                //get team user accounts
                $users = RoleUser::whereIn('team_id', $team_ids) 
                        ->orWhere('user_id', $auth_user->id);                

            } else {
                
                //get current user deposits using account ids
                $deposits = Deposit::whereIn("user_id", $user_account_ids);

                $users = RoleUser::where('user_id', $auth_user->id);

            }

            //get user accounts
            $users = $users->get();

        } 

        //search params - for filtering records based on search criteria
        if ($search) {
            
            $start_at = $request->start_at;
            $end_at = $request->end_at;
            $user_id = $request->user_id;
            $start_at_date = Carbon::parse($start_at);
            $end_at_date = Carbon::parse($end_at);

            if ($start_at) {
                $deposits = $deposits->where('created_at', '>=', $start_at_date);
            }

            if ($end_at) {
                $deposits = $deposits->where('created_at', '<=', $start_at_date);
            }

            if ($user_id) {
                $deposits = $deposits->where('user_id', '=', $user_id);
            }

        }
        //end search params 

        $deposits = $deposits->paginate(10);

        //dd($deposits, $users);

        //return view with appended url params 
        return view('deposits.index', [
            'deposits' => $deposits->appends(Input::except('page')),
            'users' => $users
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //get logged in user
        $user = auth()->user();

        if ($user->hasRole('superadministrator')){
            
            $users = User::orderBy('first_name', 'asc')
                ->get();

        } 

        if ($user->hasRole('administrator')){
            
            $users = User::whereIn('group_id', $user->group->id)
                ->orderBy('first_name', 'asc')
                ->get();

        } 

        return view('deposits.create', compact('users'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, DepositStore $depositStore)
    {
        
        $errors = [];

        $this->validate($request, [
            'amount' => 'required|integer'
        ]);

        if (!$depositStore->checkData($request))
        {
            $errors[] = $depositStore->getErrors();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        //if all is ok, create item
        $deposit = $depositStore->createItem($request);

        //send back
        $message = config('constants.success.insert');
        Session::flash('success', sprintf($message, "Deposit"));

        return redirect()->route('deposits.show', $deposit->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $permissions = ['read-deposit'];
        $team_ids = [];
        //get the deposit/ team id
        $deposit = Deposit::findOrFail($id);
        $team_id = $deposit->team_id;
        $team_ids[] = $team_id;
        //get the item owner/ user id
        $item_user_id = $deposit->user->user->id;

        //does user have read permissions? if no error returns...
        if (!isAdminGroupIdsError($team_ids, $permissions, $item_user_id)){
            
            //show details for this Deposit
            return view('deposits.show', compact('deposit'));

        } else {
            abort(404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        //is owner allowed to perform action?
        $is_owner_allowed = false;
        $permissions = ['update-deposit'];
        $team_ids = [];
        //get the deposit/ team id
        $deposit = Deposit::findOrFail($id);
        $team_id = $deposit->team_id;
        $team_ids[] = $team_id;

        //does user have edit permissions?
        if (!isAdminGroupIdsError($team_ids, $permissions, $is_owner_allowed)){
            
            //show edit details for this Deposit
            return view('deposits.edit', compact('deposit'));

        } else {
            abort(404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, DepositUpdate $depositUpdate)
    {
        
        $permissions = ['update-deposit'];
        $team_ids = [];
        //get the deposit/ team id
        $deposit = Deposit::findOrFail($id);
        $team_id = $deposit->team_id;
        $team_ids[] = $team_id;

        //does user have edit permissions?
        if (!isAdminGroupIdsError($team_ids, $permissions)){
            
            $this->validate($request, [
                'amount' => 'required',
            ]);

            if (!$depositUpdate->checkData($request))
            {
                $errors[] = $depositUpdate->getErrors();
                return redirect()->back()->withInput()->withErrors($errors);
            }

            //if all is ok, update item
            $deposit = $depositUpdate->updateItem($request, $id);

            $message = config('constants.success.update');
            Session::flash('success', sprintf($message, "Deposit"));

            return redirect()->route('deposits.show', $deposit->id);

        } 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
