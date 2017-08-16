<?php

namespace App\Http\Controllers;

use App\Group;
use App\Loan;
use App\LoanType;
use App\ScheduleSmsOutbox;
use App\Services\Loan\LoanService;
use App\User;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class LoanController extends Controller
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

        //if user is superadmin, show all loans, else show a group's loans
        $loans = [];
        if ($auth_user->hasRole('superadministrator')){
            $loans = Loan::with('user');
        } else if ($auth_user->hasRole('administrator')) {
            if ($auth_user->group_id) {
                $loans = Loan::with('user')
                        ->where("group_id", $auth_user->group_id);
            }
        } else {
            $loans = Loan::where("user_id", $auth_user->id)
                        ->with('user');
        }

        if ($search) {
            if ($search_text) {
                //$loans = $loans->user()->where('first_name', 'like', "%$search_text%");
                //$loans = $loans->where('first_name', 'like', "%$search_text%");
                $loans = $loans->where('amount', '=', "$search_text");
            }
        }

        $loans = $loans->orderBy('id', 'desc')
                        ->paginate(10);

        //dd($search_text, $loans);

        return view('loans.index', compact('loans'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //get logged in user
        $user = auth()->user();

        //if user is superadmin, show all groups, else show a user's groups
        $groups = [];
        $group_ids = [];
        //users array
        $users = [];
        if ($user->hasRole('superadministrator')){
            
            $group_ids = Group::all()->pluck('id');

            $users = User::whereIn('group_id', $group_ids)
                    ->orderBy('first_name', 'asc')
                    ->get();

        } else if ($user->hasRole('administrator')) {
            
            if ($user->group) {
                $group_ids[] = $user->group->id;

                $users = User::whereIn('group_id', $group_ids)
                    ->orderBy('first_name', 'asc')
                    ->get();
            }

        } else {

            $users = User::where('id', $user->id)
                    ->get();

        }

        $group = $user->group;

        $loan_types = LoanType::all();

        return view('loans.create', compact('users', 'group', 'loan_types'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, LoanService $loanService)
    {
        
        $errors = [];
        $user = User::findOrFail($request->user_id);

        $this->validate($request, [
            'user_id' => 'required',
            'amount' => 'required|integer',
            'period' => 'required|integer',
            'interest' => 'required|integer'
        ]);

        if (!$loanService->checkData($request))
        {
            $errors[] = $loanService->getErrors();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        //if all is ok, create item
        $loan = $loanService->createLoan($request);

        $repayments = $loan->repayments()->orderBy('id', 'desc')
                        ->paginate(10);

        //send back
        $message = config('constants.success.insert');
        Session::flash('success', sprintf($message, "Loan"));

        return redirect()->route('loans.show', $loan->id);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        //get details for this loan
        $loan = Loan::where('id', $id)
                 ->with('user')
                 ->with('loanArchives')
                 ->first();

        $repayments = $loan->repayments()->orderBy('id', 'desc')
                        ->paginate(10);

        //dd($loan, $repayments);
        
        return view('loans.show', compact('loan', 'repayments'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $loan = Loan::where('id', $id)
                 ->with('user')
                 ->first();
        
        return view('loans.edit', compact('loan'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $user_id = auth()->user()->id;

        $this->validate($request, [
            'amount' => 'required',
        ]);

        $loan = Loan::findOrFail($id);
        $loan->amount = $request->amount;
        $loan->comment = $request->comment;
        $loan->updated_by = $user_id;
        $loan->save();

        Session::flash('success', 'Successfully updated Loan id - ' . $loan->id);
        return redirect()->route('loans.show', $loan->id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
