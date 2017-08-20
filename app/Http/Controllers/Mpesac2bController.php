<?php

namespace App\Http\Controllers;

use App\Mpesac2b;
use App\Services\Mpesa\Mpesac2bStore;
use App\Services\Mpesa\Mpesac2bUpdate;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Excel;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;

class Mpesac2bController extends Controller
{
    
    public function index(Request $request)
    {

        //get logged in user
        $auth_user = auth()->user();

        $search = $request->search;
        $search_text = $request->search_text;

        //if user is superadmin, show all deposits, else show a group's deposits
        $mpesac2bs = [];
        if ($auth_user->hasRole('superadministrator')){
            
            $mpesac2bs = Mpesac2b::with('user');
            $users = User::orderBy('first_name', 'asc')->get();

        } else if ($auth_user->hasRole('administrator')) {
            
            if ($auth_user->group_id) {
                $mpesac2bs = Mpesac2b::with('user')
                        ->where("group_id", $auth_user->group_id);
            }
            $users = User::where('group_id', $auth_user->group_id)
                    ->orderBy('first_name', 'asc')
                    ->get();

        } else {
            
            $mpesac2bs = Mpesac2b::where("user_id", $auth_user->id)
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
                $mpesac2bs = $mpesas->where('created_at', '>=', $start_at_date);
            }

            if ($end_at) {
                $mpesac2bs = $mpesac2bs->where('created_at', '<=', $start_at_date);
            }

            if ($user_id) {
                $mpesac2bs = $mpesac2bs->where('user_id', '=', $user_id);
            }

        }

        $mpesac2bs = $mpesac2bs->orderBy('id', 'desc')
                        ->paginate(10);

        //return view with appended url params 
        return view('Mpesas.index', [
            'deposits' => $mpesac2bs->appends(Input::except('page')),
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

        return view('mpesa.mpesac2b.create', compact('users'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Mpesac2bStore $mpesac2bStore)
    {
                
        $errors = [];

        $this->validate($request, [
            'amount' => 'required|integer'
        ]);

        if (!$mpesac2bStore->checkData($request))
        {
            $errors[] = $mpesac2bStore->getErrors();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        //if all is ok, create item
        $mpesac2b = $mpesac2bStore->createItem($request);

        //send back
        $message = config('constants.success.insert');
        Session::flash('success', sprintf($message, "Deposit"));

        return redirect()->route('deposits.show', $mpesac2b->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        //get details for this Mpesac2b
        $mpesac2b = Mpesac2b::where('id', $id)
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
        
        $mpesac2b = Mpesac2b::where('id', $id)
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
    public function update(Request $request, $id, Mpesac2bUpdate $mpesac2bUpdate)
    {
        
        $this->validate($request, [
            'amount' => 'required',
        ]);

        if (!$mpesac2bUpdate->checkData($request))
        {
            $errors[] = $mpesac2bUpdate->getErrors();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        //if all is ok, update item
        $mpesac2b = $mpesac2bUpdate->updateItem($request, $id);

        $message = config('constants.success.update');
        Session::flash('success', sprintf($message, "Deposit"));

        return redirect()->route('deposits.show', $mpesac2b->id);

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
