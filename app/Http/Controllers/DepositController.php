<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Group;
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
        $thedate = Carbon::now('Africa/Nairobi')->local;
        $offset = Carbon::createFromTimestamp(0)->offsetHours;

        //dd($thedate, $offset);

        //get logged in user
        $auth_user = auth()->user();

        $search = $request->search;
        $search_text = $request->search_text;

        //if user is superadmin, show all deposits, else show a group's deposits
        $deposits = [];
        if ($auth_user->hasRole('superadministrator')){
            
            $deposits = Deposit::with('user');
            $users = User::orderBy('first_name', 'asc')->get();

        } else if ($auth_user->hasRole('administrator')) {
            
            if ($auth_user->group_id) {
                $deposits = Deposit::with('user')
                        ->where("group_id", $auth_user->group_id);
            }
            $users = User::where('group_id', $auth_user->group_id)
                    ->orderBy('first_name', 'asc')
                    ->get();

        } else {
            
            $deposits = Deposit::where("user_id", $auth_user->id)
                        ->with('user');
            $users = User::where('id', $auth_user->id)
                    ->orderBy('first_name', 'asc')
                    ->get();

        }

        //search params
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

        $deposits = $deposits->orderBy('id', 'desc')
                        ->paginate(10);

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
        
        //get details for this Deposit
        $deposit = Deposit::where('id', $id)
                 ->with('user')
                 ->first();
        
        return view('deposits.show', compact('deposit'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $deposit = Deposit::where('id', $id)
                 ->with('user')
                 ->first();
        
        return view('deposits.edit', compact('deposit'));

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
