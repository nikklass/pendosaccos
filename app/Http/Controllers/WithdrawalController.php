<?php

namespace App\Http\Controllers;

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
        
        //dump($request);

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
                //$withdrawals = $withdrawals->user()->where('first_name', 'like', "%$search_text%");
                //$withdrawals = $withdrawals->where('first_name', 'like', "%$search_text%");
                $withdrawals = $withdrawals->where('amount', '=', "$search_text");
            }
        }

        $withdrawals = $withdrawals->orderBy('id', 'desc')
                        ->paginate(10);

        //dd($search_text, $withdrawals);

        return view('withdrawals.index', compact('withdrawals'));
        //return redirect()->back()->withInput();

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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $auth_user = auth()->user();
        $user_id = $auth_user->id;
        $errors = [];
        $user = User::findOrFail($request->user_id);

        $this->validate($request, [
            'user_id' => 'required',
            'amount' => 'required'
        ]);

        //get users current balance
        $account_balance = (float)$user->account_balance;
        //amount withdrawn
        $amount = (float)$request->amount;

        //check if withdrawal is more than balance
        if ($amount > $account_balance) {
            $message = config('constants.error.excess_withdrawal');
            $message = sprintf($message, format_num($amount, 0), format_num($account_balance, 0));
            Session::flash('error', $message);
            return redirect()->back()->withInput();
        }

        $new_balance = $account_balance - $amount;

        DB::beginTransaction();
            
            //update the user balance
            $userAccount = User::findOrFail($request->user_id);
            $userAccount->account_balance = $new_balance;
            $userAccount->save();

            $withdrawal = Withdrawal::create([
                    'user_id' => $user->id,
                    'group_id' => $user->group_id,
                    'amount' => $amount,
                    'comment' => $request->comment,
                    'updated_by' => $user_id,
                    'created_by' => $user_id,
                    'src_host' => getUserAgent(),
                    'src_ip' => getIp()
              ]);

            $withdrawal->save();

        DB::commit();

        //send back
        Session::flash('success', "Withdrawal successfully made");
        return view('withdrawals.show', compact('withdrawal', 'user'));
        //return redirect()->back()->withInput();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->amount = $request->amount;
        $withdrawal->comment = $request->comment;
        $withdrawal->updated_by = $user_id;
        $withdrawal->save();

        Session::flash('success', 'Successfully updated withdrawal id - ' . $withdrawal->id);
        return redirect()->route('withdrawals.show', $withdrawal->id);

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
