<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Role;
use App\RoleUser;
use App\Services\User\UserStore;
use App\Services\User\UserUpdate;
use App\Team;
use App\User;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;

class MemberAccountController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $user = auth()->user();

        //if user is superadmin, show all groups, else show a user's teams
        $teams = [];
        if ($user->hasRole('superadministrator')){

            $teams = Team::all()->pluck('id');

        } else if ($user->hasRole('administrator')) {

            if ($user->teams) {
                foreach ($user->teams as $team) {
                    $teams[] = $team->id;
                }
                
            }

        }

        //get users
        $users = RoleUser::whereIn('team_id', $teams)
                ->orderBy('team_id', 'asc')
                ->paginate(10);

        return view('member-accounts.index', compact('user', 'users'));

    }

    /*show user create form*/
    public function create()
    {
        
        $user = auth()->user();
        $usergroup = User::where('id', $user->id)
            ->with('group')
            ->first();
        //if user is superadmin, show all groups, else show a user's groups
        $groups = [];
        if ($user->hasRole('superadministrator')){
            $groups = Team::all();
        } else {
            $groups = $user->group;
        }

        return view('member-accounts.create')
            ->withgroups($groups)
            ->withUser($usergroup);

    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request, UserStore $userStore)
    {

        $this->validate(request(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'account_number' => 'required',
            'email' => 'email|unique:users',
            'phone_number' => 'required|max:13'
        ]);

        if (!$userStore->checkData($request))
        {
            $errors[] = $userStore->getErrors();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        //if all is ok, create item
        $user = $userStore->createUser($request);

        //send back
        $message = config('constants.success.insert');
        Session::flash('success', sprintf($message, "User"));

        return $this->registered(request(), $user)
                        ?: redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $user = RoleUser::where('id', $id)->first();

        $loans = $user->loans()->orderBy('id', 'desc')
                        ->paginate(10);
        
        return view('member-accounts.show', compact('user', 'loans'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) 
    {

        $user = User::where('id', $id)
            ->with('roles')
            ->with('teams')
            ->first();

        //if user is superadmin, show all groups, else show a user's groups
        $groups = [];
        if (auth()->user()->hasRole('superadministrator')){
            $groups = Team::orderBy('name', 'asc')->get();
        } else {
            $groups[] = $user->group;
        }

        //get all roles
        $roles = Role::all();

        return view("member-accounts.edit", compact('user', 'roles', 'groups'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, UserUpdate $userUpdate)
    {
                
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'sometimes|email|unique:users,email,'.$id,
            'account_number' => 'required',
            'phone_number' => 'required|max:13'
        ]);

        if (!$userUpdate->checkData($request, $id))
        {
            $errors[] = $userUpdate->getErrors();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        //if all is ok, update item
        $user = $userUpdate->updateUser($request, $id);

        //send back
        $message = config('constants.success.update');
        Session::flash('success', sprintf($message, "User"));

        return redirect()->route('member-accounts.show', $user->id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect('member-accounts.index');
    }


}
