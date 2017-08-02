<?php

namespace App\Http\Controllers;

use App\Company;
use App\Group;
use App\Http\Controllers\Controller;
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

        //if user is superadmin, show all companies, else show a user's companies
        $companies = [];
        if ($user->hasRole('superadministrator')){
            $companies = Company::all()->pluck('id');
        } else {
            if ($user->company) {
                $companies[] = $user->company->id;
            }
        }
        //dd($user);

        //get company users/ groups
        $users = [];
        $groups = [];

        if ($companies) {

            $groups = Group::whereIn('company_id', $companies)
                     ->orderBy('id', 'desc')
                     ->with('company')
                     ->paginate(10);
        
            $users = User::whereIn('company_id', $companies)
                    ->orderBy('id', 'desc')
                    ->with('company')
                    ->paginate(10);

            $smsoutboxes = SmsOutbox::whereIn('company_id', $companies)
                    ->orderBy('id', 'desc')
                    ->get();
                    //->paginate(10);

            $groups_all = Group::whereIn('company_id', $companies)
                     ->orderBy('id', 'desc')
                     ->get();

            //sms outbox count
            $count_smsoutbox = count($smsoutboxes);
            $user->sms_outbox_count = $count_smsoutbox;
            
            //groups count
            $count_groups = count($groups_all);
            $user->count_groups = $count_groups;

        }

        //dd($user, $smsoutboxes);
        
        return view('home', compact('smsoutboxes'))
            ->withUser($user)
            ->withUsers($users)
            ->withSmsOutboxes($smsoutboxes)
            ->withGroups($groups);

    }

}
