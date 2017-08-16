<?php

namespace App\Http\Controllers;

use App\Events\AccountAdded;
use App\Group;
use App\Http\Controllers\Controller;
use App\Role;
use App\Services\User\UserUpdate;
use App\User;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $user = auth()->user();

        //if user is superadmin, show all groups, else show a user's groups
        $groups = [];
        if ($user->hasRole('superadministrator')){
            $groups = Group::all()->pluck('id');
        } else if ($user->hasRole('administrator')) {
            if ($user->group) {
                $groups[] = $user->group->id;
            }
        }

        //get group users
        $users = [];

        if ($groups) { 

            $users = User::whereIn('group_id', $groups)
                    ->orderBy('id', 'desc')
                    ->with('group')
                    ->with('roles')
                    ->paginate(10);

        }

        //dd($users, $groups);

        return view('users.index')
                ->withUser($user)
                ->withUsers($users);

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
            $groups = Group::all();
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

    public function store(Request $request)
    {

        $this->validate(request(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'account_number' => 'required',
            'email' => 'email|unique:users',
            'phone_number' => 'required|max:13'
        ]);

        $phone_number = '';
        if ($request->phone_number) {
            if (!isValidPhoneNumber($request->phone_number)){
                $message = config('constants.error.invalid_phone_number');
                Session::flash('error', $message);
                return redirect()->back()->withInput();
            }
            $phone_number = formatPhoneNumber($request->phone_number);
        }

        //generate random password
        $password = generateCode(6);

        // create user
        $userData = [
            'first_name' => request()->first_name,
            'last_name' => request()->last_name,
            'email' => request()->email,
            'group_id' => request()->group_id,
            'account_number' => request()->account_number,
            'account_balance' => request()->account_balance,
            'gender' => request()->gender,
            'phone_number' => $phone_number,
            'password' => bcrypt($password),
            'api_token' => str_random(60),
            'created_by' => request()->user()->id,
            'updated_by' => request()->user()->id
        ];

        $user = User::create($userData);

        session()->flash("success", "User successfully created");
        return $this->registered(request(), $user)
                        ?: redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $user = User::where('id', $id)->with('roles')->first();

        $loans = $user->loans()->orderBy('id', 'desc')
                        ->paginate(10);
        
        return view('users.show', compact('user', 'loans'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) 
    {

        $user = User::where('id', $id)
            ->with('roles')
            ->with('group')
            ->first();

        //if user is superadmin, show all groups, else show a user's groups
        $groups = [];
        if (auth()->user()->hasRole('superadministrator')){
            $groups = Group::orderBy('name', 'asc')->get();
        } else {
            $groups[] = $user->group;
        }

        //get all roles
        $roles = Role::all();

        return view("users.edit", compact('user', 'roles', 'groups'));

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

        return redirect()->route('users.show', $id);

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
