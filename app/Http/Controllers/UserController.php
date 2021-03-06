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

class UserController extends Controller
{
    
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $user = auth()->user();

        //if user is superadmin, show all groups, else show a user's groups
        $groups = [];
        if ($user->hasRole('superadministrator')){
            $groups = Team::all()->pluck('id');
        } else if ($user->hasRole('administrator')) {
            if ($user->teams) {
                foreach ($user->teams as $team) {
                    $groups[] = $team->id;
                }
            }
        }

        //get group users
        $users = [];

        if ($groups) { 

            $users = User::orderBy('id', 'desc')
                    ->paginate(10);

        }

        return view('users.index', compact('user', 'users'));

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

        return view('users.create')
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

        //get user object
        $user = User::where('id', $id)
                ->with('roles')
                ->first();

        //get user accounts, with user roles only
        $user_role_id = Role::where('name', 'user')->pluck('id');

        $user_accounts = $user->accounts()
                        ->where('role_id', $user_role_id)
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        $user_roles = $user->accounts()
                        ->where('role_id', '!=', $user_role_id)
                        ->get();

        //dd($user_accounts);

        //get user loans
        $loans = $user->loans()->orderBy('id', 'desc')
                        ->paginate(10);
        
        return view('users.show', compact('user', 'loans', 'user_accounts', 'user_roles'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) 
    {

        $user = User::where('id', $id)
            ->with('roles')
            ->first();

        //get all user account team ids
        $user_account_team_ids = $user->accounts()->pluck('team_id');

        //check user permission on teams/ groups
        $filtered_team_ids = getAdminGroupIds($user_account_team_ids, 'edit-user');

        //get user accounts
        $user_accounts = $user->accounts()
                        ->whereIn('team_id', $filtered_team_ids)
                        //->groupBy('team_id')
                        ->paginate(10);
        
        $user_accounts_unique = $user_accounts->unique('team_id');

        //$unique->values()->all();

        //dd($user_accounts);

        //get all roles
        $roles = Role::all();

        return view("users.edit", compact('user', 'roles', 'user_accounts', 'user_accounts_unique'));

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

        return redirect()->route('users.show', $user->id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect('users.index');
    }


}
