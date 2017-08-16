<?php

namespace App\Http\Controllers;

use App\Account;
use App\Group;
use App\ScheduleSmsOutbox;
use App\SmsOutbox;
use App\User;
use Excel;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request;
use Session;

class AccountController extends Controller
{
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
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        //dd($request);

        //get logged in user
        $auth_user = auth()->user();

        $search_text = $request->search_text;

        //if user is superadmin, show all accounts, else show a group's accounts
        $accounts = [];
        if ($auth_user->hasRole('superadministrator')){
            $accounts = Account::all()->with('user');
        } else if ($auth_user->hasRole('administrator')) {
            if ($auth_user->group_id) {
                $accounts = Account::where("group_id", $auth_user->group_id)
                        ->with('user');
            }
        } else {
            $accounts = Account::where("user_id", $auth_user->id)
                        ->with('user');
        }

        $accounts = $accounts->orderBy('id', 'desc')
                        ->paginate(10);

                        //dd($accounts);

        return view('accounts.index', compact('accounts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //get logged in user
        $user = auth()->user();

        $usergroup = User::where('id', $user->id)
            ->with('group')
            ->first();

        //if user is superadmin, show all groups, else show a user's groups
        $groups = [];
        $group_ids = [];
        if ($user->hasRole('superadministrator')){
            $group_ids = group::all()->pluck('id');
            $groups = group::all();
        } else if ($user->hasRole('administrator')) {
            if ($user->group) {
                $group_ids[] = $user->group->id;
                $groups[] = $user->group;
            }
        }

        //get group smsoutbox
        $users = [];

        if ($group_ids) {

            $users = User::whereIn('group_id', $group_ids)
                    ->orderBy('id', 'desc')
                    ->with('group')
                    ->get();

        }

        return view('accounts.create')
               ->withUsers($users);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dump($request);
        $auth_user = auth()->user();
        $user_id = $auth_user->id;
        $admin_group_id = $auth_user->group_id;
        $admin_user = User::findOrFail($auth_user->id);

        $errors = [];
        $user = User::findOrFail($request->user_id);
        $user_full_names = $user->first_name . ' ' . $user->last_name;

        $this->validate($request, [
            'user_id' => 'required',
            'account_number' => 'required',
            'account_balance' => 'required|integer'
        ]);

        //check if account number/ group id combi is unique
        $user_check = Account::where('group_id', $admin_group_id)
                        ->where('user_id', $request->user_id)
                        ->first();

        $account_number_check = Account::where('group_id', $admin_group_id)
                        ->where('account_number', $request->account_number)
                        ->first();

        if (count($user_check)){
            $errors[] = "User  \"" . $user_full_names . "\" already exists in this group \"" 
                        . $admin_user->group->name . "\"";
            return redirect()->back()->withInput()->withErrors($errors);
        }

        if (count($account_number_check)){
            $errors[] = "Account Number \"" . $request->account_number . "\" already exists in this group \"" 
                        . $admin_user->group->name . "\"";
            return redirect()->back()->withInput()->withErrors($errors);
        }

        $account = Account::create([
                'user_id' => $user->id,
                'group_id' => $admin_user->group_id,
                'account_number' => $request->account_number,
                'account_balance' => $request->account_balance,
                'comment' => $request->comment,
                'updated_by' => $user_id,
                'created_by' => $user_id,
                'src_host' => getUserAgent(),
                'src_ip' => getIp()
          ]);

        $account->save();

        //send back
        Session::flash('success', "Account successfully added");
        //return redirect()->back()->withInput();
        return view('accounts.index');

    }

    /**
     * Display an account
     */
    public function show($id)
    {
        
        //get details for this account
        $account = Account::where('id', $id)
                 ->with('user')
                 ->with('accountArchives')
                 ->first();

        return view('accounts.show', compact('account'));

    }

    /**
     * Show the form for editing 
     */
    public function edit($id)
    {
        
        $account = Account::where('id', $id)
                 ->with('user')
                 ->first();
        
        return view('accounts.edit', compact('account'));

    }

    /**
     * Update the account resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $user_id = auth()->user()->id;

        $this->validate($request, [
            'amount' => 'required',
        ]);

        $account = Account::findOrFail($id);
        $account->amount = $request->amount;
        $account->comment = $request->comment;
        $account->updated_by = $user_id;
        $account->save();

        Session::flash('success', 'Successfully updated account id - ' . $account->id);
        return redirect()->route('accounts.show', $account->id);

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
