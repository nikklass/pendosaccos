<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Group;
use App\Http\Controllers\Controller;
use App\Loan;
use App\Role;
use App\SmsOutbox;
use App\Team;
use App\User;
use Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        /*************TEST**************/
        //get user teams
        $team_ids = [];
        foreach ($user->teams as $team) {
            $team_ids[] = $team->id;
        }

        //dd($user->teams, $team_ids);

        /***********END TEST*************/

        if ($user->hasRole('superadministrator')){
            
            $team_ids = Team::all()->pluck('id');
            $teams = Team::all();

            //get teams balance
            $teams_balance = Team::selectRaw('sum(account_balance) account_balance')
                ->first();

            //get teams loans
            $teams_loans = Loan::selectRaw('sum(loan_balance) loan_balance')
                ->first();

            //get month deposits
            $month_deposits = Deposit::selectRaw('sum(amount) amount')
                ->whereRaw('MONTH(created_at) = ?', [$month])
                ->whereRaw('YEAR(created_at) = ?', [$year])
                ->first();

        } else { 

            //get user teams
            $team_ids = [];
            foreach ($user->teams as $team) {
                $team_ids[] = $team->id;
            }

            if (count($team_ids) > 0) {
                $teams[] = Team::whereIn('id', $team_ids);

                //get teams balance
                $teams_balance = Team::select('account_balance')
                    ->whereIn('id', $team_ids)
                    ->first();

                //get teams loans
                $teams_loans = Loan::selectRaw('sum(loan_balance) loan_balance')
                    ->whereIn('team_id', $team_ids)
                    ->first();

                //get month deposits
                $month_deposits = Deposit::selectRaw('sum(amount) amount')
                    ->whereIn('team_id', $team_ids)
                    ->whereRaw('MONTH(created_at) = ?', [$month])
                    ->whereRaw('YEAR(created_at) = ?', [$year])
                    ->first();

            }

        }

        //get users/ teams
        $users = [];

        if ($team_ids) {

            $users = DB::table('users')
                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                    ->whereIn('role_user.team_id', $team_ids)
                    ->orderBy('users.id', 'desc')
                    ->paginate(10);

            
            //get new users in user group
            $new_users = DB::table('role_user')
                    ->join('users', 'role_user.user_id', '=', 'users.id')
                    ->join('teams', 'role_user.team_id', '=', 'teams.id')
                    ->whereIn('role_user.team_id', $team_ids)
                    ->orderBy('role_user.id', 'desc')
                    ->paginate(10);

            //dd($new_users);

            $smsoutboxes = SmsOutbox::whereIn('team_id', $team_ids)
                    ->orderBy('id', 'desc')
                    ->get();
                    //->paginate(10);

            $teams_all = Team::whereIn('id', $team_ids)
                     ->orderBy('id', 'desc')
                     ->paginate(10);

            //sms outbox count
            $count_smsoutbox = count($smsoutboxes);
            $user->sms_outbox_count = $count_smsoutbox;
            
            //teams count
            $count_teams = count($teams);
            $user->count_teams = $count_teams;

        }

        //get summary of team balances
        /*$loans_amount = Loan::selectRaw('year(created_at) year, month(created_at) month, sum(loan_amount) loan_amount')
                ->groupBy('year', 'month')
                ->get();*/
        
        return view('home', compact(
                                    'smsoutboxes', 
                                    'user', 
                                    'users', 
                                    'new_users',
                                    'teams_balance',
                                    'teams_loans',
                                    'month_deposits'
                                    ))->withteams($teams_all);
        

    }

}
