<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Company;
use Session;

class GroupController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::orderBy('id', 'desc')->paginate(10);
        return view('groups.index')->withGroups($groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        //if user is superadmin, show all companies, else show a user's companies
        if ($user->hasRole('superadministrator')){
            $companies = Company::all();
        } else {
            $companies = $user->companies;
        }
        return view('groups.create')->withCompanies($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user_id = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required|max:255',
            'company_id' => 'required'
        ]);

        if (!isValidPhoneNumber($request->phone_number)){
            $message = \Config::get('constants.error.invalid_phone_number');
            Session::flash('error', $message);
            return redirect()->back()->withInput();
        }

        $group = new Group();
        $group->name = $request->name;
        $group->company_id = $request->company_id;
        $group->phone_number = formatPhoneNumber($request->phone_number);
        $group->email = $request->email;
        $group->physical_address = $request->physical_address;
        $group->box = $request->box;
        $group->created_by = $user_id;
        $group->updated_by = $user_id;
        $group->save();

        Session::flash('success', 'Successfully created new group - ' . $group->name);
        return redirect()->route('groups.show', $group->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        //get admin user for this group
        $group = Group::where('id', $id)
                 ->with('company')
                 ->first();
        
        return view('groups.show')->withGroup($group);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $group = Group::where('id', $id)
                 ->with('company')
                 ->first();

        $user = auth()->user();
        //if user is superadmin, show all companies, else show a user's companies
        if ($user->hasRole('superadministrator')){
            $companies = Company::all();
        } else {
            $companies = $user->companies;
        }
        
        return view('groups.edit')->withGroup($group)->withCompanies($companies);

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
            'name' => 'required|max:255',
            'phone_number' => 'required|max:255',
            'company_id' => 'required|max:255'
        ]);

        $group = Group::findOrFail($id);
        $group->name = $request->name;
        $group->company_id = $request->company_id;
        $group->phone_number = $request->phone_number;
        $group->email = $request->email;
        $group->physical_address = $request->physical_address;
        $group->box = $request->box;
        $group->updated_by = $user_id;
        $group->save();

        Session::flash('success', 'Successfully updated group - ' . $group->name);
        return redirect()->route('groups.show', $group->id);

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
