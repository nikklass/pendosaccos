<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class UserImportController extends Controller
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
        return view('bulk-users.index');
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
        if (!count($companies)) {
            $companies = [];
        }
        //dd($companies);
        return view('bulk-users.create')->withCompanies($companies);

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

        $validator = Validator::make($request->all(), [
            'import_file' => 'required'
            
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                -withInput();
        }

        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            //dd($data);
            if (!empty($data) && $data->count()) {
                
                $errors = [];

                //check for errors in submitted data
                foreach ($data as $key => $value) {
                    
                    if (!$value->first_name) {
                        $errors['first_name'] = "First Name missing in supplied data";
                    }

                    if (!$value->last_name) {
                        $errors['last_name'] = "Last Name missing in supplied data";
                    }

                    if (!$value->phone_number) {
                        $errors['phone_number'] = "Phone Number missing in supplied data";
                    }

                    if (!isValidPhoneNumber($value->phone_number)){
                        //$message = \Config::get('constants.error.invalid_phone_number');
                        $errors['phone_number'] = "Phone Number <strong>" . $value->phone_number . "</strong> is Invalid. Please use formats: <br>7XXXXXXXX or 07XXXXXXXX or 2547XXXXXXXX or +2547XXXXXXXX";
                    }

                }

                if (count($errors)) {

                    return redirect()->route('bulk-users.create')
                        ->withErrors($errors)
                        ->withInput();

                } else {
                    
                    $i = 0;

                    //insert data
                    foreach ($data as $key => $value) {
                        
                        // create user
                        $userData = [
                            'account_number' => $value->account_number,
                            'first_name' => $value->first_name,
                            'last_name' => $value->last_name,
                            'gender' => $value->gender,
                            'email' => $value->email,
                            'phone_number' => formatPhoneNumber($value->phone_number),
                            'company_id' => $request->company_id,
                            'created_by' => auth()->user()->id,
                            'updated_by' => auth()->user()->id
                        ];

                        $user = User::create($userData);

                        $i++;

                    }

                }

            }
            Session::flash('success', 'Successfully inserted <strong>' . $i . '</strong> users');
            return redirect()->route('users.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        //$company = Company::where('id', $id)->first();

        return view('bulk-users.show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        //$company = Company::where('id', $id)->first();
        return view('bulk-users.edit');

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
