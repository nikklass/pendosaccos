<?php

namespace App\Http\Controllers;

use App\Company;
use App\Group;
use App\Http\Controllers\Controller;
use App\Role;
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
        //dd($companies);

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

        }

        //dd($groups);
        
        return view('home')
            ->withUsers($users)
            ->withGroups($groups);

    }

}
