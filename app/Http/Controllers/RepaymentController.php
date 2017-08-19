<?php

namespace App\Http\Controllers;

use App\Group;
use App\Loan;
use App\Repayment;
use App\ScheduleSmsOutbox;
use App\Services\Repayment\RepaymentStore;
use App\SmsOutbox;
use App\User;
use Excel;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;

class RepaymentController extends Controller
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

        //if user is superadmin, show all repayments, else show a group's repayments
        $repayments = [];
        if ($auth_user->hasRole('superadministrator')){
            $repayments = Repayment::with('loan');
        } else if ($auth_user->hasRole('administrator')) {
            if ($auth_user->group_id) {
                $repayments = Repayment::with('loan')
                        ->where("group_id", $auth_user->group_id);
            }
        } else {
            $repayments = Repayment::where("user_id", $auth_user->id)
                        ->with('loan');
        }

        if ($search) {
            if ($search_text) {
                //$repayments = $repayments->user()->where('first_name', 'like', "%$search_text%");
                //$repayments = $repayments->where('first_name', 'like', "%$search_text%");
                $repayments = $repayments->where('amount', '=', "$search_text");
            }
        }

        $repayments = $repayments->orderBy('id', 'desc')
                        ->paginate(10);

        //dd($repayments);

        return view('repayments.index', compact('repayments'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        //get logged in user
        $user = auth()->user();

        if (($user->hasRole('superadministrator')) || ($user->hasRole('administrator'))){
            
            $loan = Loan::where('id', $request->loan_id)
                ->with('user')
                ->first();

            //get loan repayments
            $repayments = $loan->repayments()->orderBy('id', 'desc')
                        ->paginate(10);

        } 

        return view('repayments.create', [
            'repayments' => $repayments->appends(Input::except('page')),
            'loan' => $loan
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RepaymentStore $repaymentStore)
    {
        
        $errors = [];

        $this->validate($request, [
            'loan_id' => 'required',
            'amount' => 'required|integer'
        ]);

        if (!$repaymentStore->checkData($request))
        {
            $errors[] = $repaymentStore->getErrors();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        //if all is ok, create item
        $repaymentStore->createRepayment($request);

        //send back
        $message = config('constants.success.insert');
        Session::flash('success', sprintf($message, "Repayment"));

        return redirect()->back()->withInput();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        //get details for this repayment
        $repayment = Repayment::where('id', $id)
                 ->with('user')
                 ->with('repaymentArchives')
                 ->first();
        
        return view('repayments.show', compact('repayment'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $repayment = repayment::where('id', $id)
                 ->with('user')
                 ->first();
        
        return view('repayments.edit', compact('repayment'));

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

        $repayment = Repayment::findOrFail($id);
        $repayment->amount = $request->amount;
        $repayment->comment = $request->comment;
        $repayment->updated_by = $user_id;
        $repayment->save();

        Session::flash('success', 'Successfully updated repayment id - ' . $repayment->id);
        return redirect()->route('repayments.show', $repayment->id);

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
