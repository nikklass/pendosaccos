<?php

namespace App\Http\Controllers;

use App\Services\Withdrawal\WithdrawalStore;
use App\Services\Withdrawal\WithdrawalUpdate;

use App\Group;
use App\ScheduleSmsOutbox;
use App\SmsOutbox;
use App\User;
use App\Withdrawal;
use Excel;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class WithdrawalController extends Controller
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
        
        //get logged in user
        $auth_user = auth()->user();

        $search = $request->search;
        $search_text = $request->search_text;

        //if user is superadmin, show all withdrawals, else show a group's withdrawals
        $withdrawals = [];
        if ($auth_user->hasRole('superadministrator')){
            $withdrawals = Withdrawal::with('user');
        } else if ($auth_user->hasRole('administrator')) {
            if ($auth_user->group_id) {
                $withdrawals = Withdrawal::with('user')
                        ->where("group_id", $auth_user->group_id);
            }
        } else {
            $withdrawals = Withdrawal::where("user_id", $auth_user->id)
                        ->with('user');
        }

        if ($search) {
            if ($search_text) {
                $withdrawals = $withdrawals->where('amount', '=', "$search_text");
            }
        }

        $withdrawals = $withdrawals->orderBy('id', 'desc')
                        ->paginate(10);

        return view('withdrawals.index', compact('withdrawals'));

    }

    /**
     * Show the form for creating a new resource.
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
        //users array
        $users = [];
        if ($user->hasRole('superadministrator')){
            
            $group_ids = Group::all()->pluck('id');
            $groups = Group::all();

            $users = User::whereIn('group_id', $group_ids)
                    ->orderBy('first_name', 'asc')
                    ->with('group')
                    ->get();

        } else if ($user->hasRole('administrator')) {
            
            if ($user->group) {
                $group_ids[] = $user->group->id;
                $groups[] = $user->group;

                $users = User::whereIn('group_id', $group_ids)
                    ->orderBy('first_name', 'asc')
                    ->with('group')
                    ->get();
            }

        } else {

            $users = User::where('id', $user->id)
                    ->with('group')
                    ->get();

        }

        return view('withdrawals.create', compact('users'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, WithdrawalStore $withdrawalStore)
    {
        
        $errors = [];

        $this->validate($request, [
            'user_id' => 'required',
            'amount' => 'required'
        ]);


        if (!$withdrawalStore->checkData($request))
        {
            $errors[] = $withdrawalStore->getErrors();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        //if all is ok, create item
        $withdrawal = $withdrawalStore->createItem($request);

        //send back
        $message = config('constants.success.insert');
        Session::flash('success', sprintf($message, "Deposit"));

        return redirect()->route('withdrawals.show', $withdrawal->id);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        //get details for this withdrawal
        $withdrawal = Withdrawal::where('id', $id)
                 ->with('user')
                 ->with('withdrawalArchives')
                 ->first();
        
        return view('withdrawals.show', compact('withdrawal'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $withdrawal = Withdrawal::where('id', $id)
                 ->with('user')
                 ->first();
        
        return view('withdrawals.edit', compact('withdrawal'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, WithdrawalUpdate $withdrawalUpdate)
    {
        
        $this->validate($request, [
            'amount' => 'required',
        ]);

        if (!$withdrawalUpdate->checkData($request, $id))
        {
            $errors[] = $withdrawalUpdate->getErrors();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        //if all is ok, update item
        $withdrawal = $withdrawalUpdate->updateItem($request, $id);

        $message = config('constants.success.update');
        Session::flash('success', sprintf($message, "Withdrawal"));

        return redirect()->route('withdrawals.show', $withdrawal->id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
