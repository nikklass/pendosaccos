<?php

namespace App\Http\Controllers;

use Carbon;

use App\Group;
use App\Http\Controllers\Controller;
use App\Loan;
use App\Deposit;
use App\Role;
use App\SmsOutbox;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class HomeController extends Controller
{

    /**
     * Show the application home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user = auth()->user();

        //find current month start and end dates
        $month = Carbon::now()->month; // Current month
        $year = Carbon::now()->year; // Current month

        //if user is superadmin, show all groups, else show a user's groups
        $groups = [];
        $groups_balance = "";
        $groups_loans = "";
        $month_deposits = "";

        if ($user->hasRole('superadministrator')){
            
            $group_ids = Group::all()->pluck('id');
            $groups = Group::all();

            //get groups balance
            $groups_balance = Group::selectRaw('sum(account_balance) account_balance')
                ->first();

            //get groups loans
            $groups_loans = Loan::selectRaw('sum(loan_balance) loan_balance')
                ->first();

            //get month deposits
            $month_deposits = Deposit::selectRaw('sum(amount) amount')
                ->whereRaw('MONTH(created_at) = ?', [$month])
                ->whereRaw('YEAR(created_at) = ?', [$year])
                ->first();

        } else { 

            if ($user->group) {
                $group_ids[] = $user->group->id;
                $groups[] = $user->group;

                //get groups balance
                $groups_balance = Group::select('account_balance')
                    ->where('id', $user->group->id)
                    ->first();

                //get groups loans
                $groups_loans = Loan::selectRaw('sum(loan_balance) loan_balance')
                    ->where('group_id', $user->group->id)
                    ->first();

                //get month deposits
                $month_deposits = Deposit::selectRaw('sum(amount) amount')
                    ->where('group_id', $user->group->id)
                    ->whereRaw('MONTH(created_at) = ?', [$month])
                    ->whereRaw('YEAR(created_at) = ?', [$year])
                    ->first();

            }

        }

        //get users/ groups
        $users = [];

        if ($groups) {
        
            $users = User::whereIn('group_id', $group_ids)
                    ->orderBy('id', 'desc')
                    ->with('group')
                    ->paginate(10);

            $smsoutboxes = SmsOutbox::whereIn('group_id', $group_ids)
                    ->orderBy('id', 'desc')
                    ->get();
                    //->paginate(10);

            $groups_all = Group::whereIn('id', $group_ids)
                     ->orderBy('id', 'desc')
                     ->paginate(10);

            //sms outbox count
            $count_smsoutbox = count($smsoutboxes);
            $user->sms_outbox_count = $count_smsoutbox;
            
            //groups count
            $count_groups = count($groups);
            $user->count_groups = $count_groups;

        }

        //get summary of group balances
        /*$loans_amount = Loan::selectRaw('year(created_at) year, month(created_at) month, sum(loan_amount) loan_amount')
                ->groupBy('year', 'month')
                ->get();*/
        
        return view('home', compact(
                                    'smsoutboxes', 
                                    'user', 
                                    'users', 
                                    'groups_balance',
                                    'groups_loans',
                                    'month_deposits'
                                    ))->withGroups($groups_all);
        

    }

}
