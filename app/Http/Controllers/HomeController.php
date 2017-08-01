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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //get logged in user
        $user = auth()->user();

        //if user is superadmin, show all companies, else show a user's companies
        $companies = [];
        if ($user->hasRole('superadministrator')){
            $companies = Company::all()->pluck('id');
        } else if ($user->hasRole('administrator')) {
            $companies = $user->company->pluck('id');
        }

        //get company users
        $users = User::whereIn('company_id', $companies)
                ->orderBy('id', 'desc')
                ->with('company')
                ->paginate(10);

        //get company groups
        $groups = Group::whereIn('company_id', $companies)
                ->orderBy('id', 'desc')
                ->with('company')
                ->paginate(10);

        //dd($groups);
        
        return view('home')
            ->withUsers($users)
            ->withGroups($groups);

    }

}
