<?php

namespace App\Http\Controllers;

use App\RoleUser;
use App\ScheduleSmsOutbox;
use App\SmsOutbox;
use App\Team;
use App\User;
use App\Role;
use Excel;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request;
use Session;

class SmsOutboxController extends Controller
{

    /**
     * Display a listing of the resource.
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
            if ($user->company) {
                $companies = $user->company->pluck('id');
            }
        }

        //get company smsoutbox
        $users = [];
        $groups = [];

        if ($companies) {
        
            $smsoutboxes = SmsOutbox::whereIn('company_id', $companies)
                    ->orderBy('id', 'desc')
                    ->with('company')
                    ->with('user')
                    ->paginate(10);

        }

        //dd($smsoutboxes);
        return view('smsoutbox.index', compact('smsoutboxes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //get logged in user
        $user = auth()->user();

        //get user accounts, with user roles only
        $user_role_id = Role::where('name', 'user')->pluck('id');

        $userCompany = User::where('id', $user->id)
            ->first();

        //if user is superadmin, show all companies, else show a user's companies
        $teams = [];
        $team_ids = [];
        if ($user->hasRole('superadministrator')){
            $team_ids = Team::all()->pluck('id');
            $teams = Team::all();
        } else if ($user->hasRole('administrator')) {
            $team_ids = $user->teams->pluck('id');
            $team_ids = getAdminGroupIds($team_ids, 'create-bulk-sms');
        }
        dd($team_ids);

        //get company smsoutbox
        $users = [];
        $groups = [];

        if ($team_ids) {
        
            $smsoutboxes = SmsOutbox::whereIn('team_id', $team_ids)
                    ->orderBy('id', 'desc')
                    ->with('user')
                    ->get();

            $groups = Team::whereIn('id', $team_ids)
                    ->orderBy('id', 'desc')
                    ->get();

            $users = RoleUser::whereIn('team_id', $team_ids)
                    ->where('role_id', $user_role_id)
                    ->where('team_id', '!=', '1')
                    ->orderBy('id', 'desc')
                    ->get();

        }

        //dd($users);

        //get bulk sms data
        $bulk_sms_data = getBulkSMSData($user->id); 
        dd($bulk_sms_data);
        
        if (!$bulk_sms_data['error']) {
            $default_source = $bulk_sms_data['default_source'];
            if ($default_source) {
                $sms_balance = $bulk_sms_data['sms_balance'];
            }
        } else {
            $sms_balance = 0;
        }

        $userCompany->sms_balance = format_num($sms_balance, 0);
        //dd($bulk_sms_data, $user);

        return view('smsoutbox.create', compact('smsOutboxes', 'teams', 'users'))
               ->withUser($userCompany);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $auth_user = auth()->user();
        $user_id = $auth_user->id;
        $errors = [];

        $this->validate($request, [
            'sms_message' => 'required'        
        ]);

        $bulk_sms_data = getBulkSMSData($user_id);

        if (!$bulk_sms_data['error']) {

            //dd($bulk_sms_data);
            $usr = $bulk_sms_data['sms_user_name'];
            $src = $bulk_sms_data['default_source'];
            $pass = $bulk_sms_data['passwd'];

            $usersSelected = explode(',', $request->usersSelected);
            $sms_message = trim($request->sms_message);
                
            //formulate sms message if excel file was loaded
            if ($request->attachContent) {

                //read sms and check for delimiters in sms box
                $matches_regex = "/\[\[(\w+)\]\]/";
                $remove_spaces_regex = "/\s+/";

                //remove all spaces
                $regex_message = preg_replace($remove_spaces_regex, ' ', $sms_message);
                $regex_message = strtolower($regex_message);

                //get the replaceable matches
                $hits = preg_match_all($matches_regex, $regex_message, $match_results, PREG_PATTERN_ORDER);

                //dump($match_results[0]); //match full pattern
                //dd($match_results[1]); //match in brackets
                $match_results_full = $match_results[0];
                $match_results = $match_results[1];

                //read excel file if it exists
                if ($request->hasFile('import_file') && count($match_results)) {
            
                    $company_id = null;
                    if ($auth_user->company) {
                        $company_id = $auth_user->company->id;
                    }
                    //dump($company_id);
                    $path = $request->file('import_file')->getRealPath();
                    $data = Excel::load($path, function($reader) {
                    })->get();
                    
                    //get column titles/ headers
                    $line0 = $data[0];
                    $headers = $line0->keys();

                    $sent_sms_count = 0;
                    
                    //insert sms outbox data
                    foreach ($data as $key => $value) {
                        
                        //init sms_message in each loop
                        $local_sms_message = $sms_message;
                        $local_phone_number = null;
                        
                        //get values from excel and map to sms_message
                        //loop thru headers and get values assigned in $data array
                        //generate the message
                        foreach ($headers as $key => $header) {
                            
                            $header = strtolower($header);

                            //get the phone number
                            if ($header == "phone_number") {
                                $local_phone_number = $value[$header];
                            }

                            //check if $header is in sms_message, 
                            //assign to markers present in sms
                            if (in_array($header, $match_results)) {
                                //get the items value from excel file
                                $item_value = $value[$header];
                                $item_value_regex = "/\[\[$header\]\]/i";
                                //dump($item_value_regex);
                                //replace sms_message placeholder with this value
                                $local_sms_message = preg_replace($item_value_regex, $item_value, $local_sms_message);
                            }

                        }
                        //end generate the message

                        //dump($local_sms_message);

                        // send sms
                        if ($request->sendSmsCheckBox == 'now') {

                            $params['usr'] = $usr;
                            $params['pass'] = $pass;
                            $params['src'] = $src;
                            $params['phone_number'] = $local_phone_number;
                            $params['sms_message'] = $local_sms_message;

                            $response = sendSms($params);

                            //format local phone number
                            $local_phone_number = formatPhoneNumber($local_phone_number);

                            //find user who owns phone number 
                            $local_user_id = null;
                            if ($local_phone_number) {
                                $local_user = User::where('phone_number', $local_phone_number)
                                                    ->where('company_id', $company_id)
                                                    ->first();
                                if ($local_user) {
                                    $local_user_id = $local_user->id;
                                }
                            }                        

                            if ($response['mobile']) {

                                //create new outbox
                                $smsoutbox = new SmsOutbox();
                                $smsoutbox->message = $local_sms_message;
                                $smsoutbox->short_message = reducelength($local_sms_message, 45);
                                $smsoutbox->user_id = $local_user_id;
                                $smsoutbox->phone_number = $local_phone_number;
                                $smsoutbox->company_id = $request->company_id;
                                $smsoutbox->sms_user_name = $usr;
                                $smsoutbox->user_agent = getUserAgent();
                                $smsoutbox->src_ip = getIp();
                                $smsoutbox->src_host = getHost();
                                $smsoutbox->created_by = $user_id;
                                $smsoutbox->updated_by = $user_id;
                                $smsoutbox->save();

                            } else {

                                //$errors['sms'] = $response->message;

                            }

                        } else {
                            
                            //create new scheduled sms outbox
                            $schedulesmsoutbox = new ScheduleSmsOutbox();
                            $schedulesmsoutbox->message = $local_sms_message;
                            $schedulesmsoutbox->short_message = reducelength($local_sms_message, 45);
                            $schedulesmsoutbox->user_id = $local_user_id;
                            $schedulesmsoutbox->phone_number = $local_phone_number;
                            $schedulesmsoutbox->company_id = $request->company_id;
                            $schedulesmsoutbox->sms_user_name = $usr;
                            $schedulesmsoutbox->user_agent = getUserAgent();
                            $schedulesmsoutbox->src_ip = getIp();
                            $schedulesmsoutbox->src_host = getHost();
                            $schedulesmsoutbox->created_by = $user_id;
                            $schedulesmsoutbox->updated_by = $user_id;
                            $schedulesmsoutbox->save();

                        }

                        $sent_sms_count++;
                        
                    }

                    Session::flash('success', "<strong>$sent_sms_count</strong> SMS successfully sent/ scheduled");
                    return redirect()->back();

                } else {
                    //throw an error msg here
                    //send back
                    Session::flash('error', "Please select excel file and have [[markers]] in your sms message");
                    return redirect()->back()->withInput();
                }

            }

            //if users is selected and not attach content selected
            if ((count($usersSelected) > 0) && (!$request->attachContent)){
                
                //send message(s)
                foreach ($usersSelected as $x) {
                    
                    //get the recipient user details
                    $user = User::where('id', $x)->first();

                    if ($request->sendSmsCheckBox == 'now') {

                        $params['usr'] = $usr;
                        $params['pass'] = $pass;
                        $params['src'] = $src;
                        $params['phone_number'] = $user->phone_number;
                        $params['sms_message'] = $request->sms_message;
                        //dump($params);

                        //$response['error'] = true;
                        $response = sendSms($params);

                        //dd($response);

                        if (!$response['error']) {
                            
                            //create new outbox
                            $smsoutbox = new SmsOutbox();
                            $smsoutbox->message = $request->sms_message;
                            $smsoutbox->short_message = reducelength($request->sms_message,45);
                            $smsoutbox->user_id = $x;
                            $smsoutbox->company_id = $request->company_id;
                            $smsoutbox->sms_user_name = $usr;
                            $smsoutbox->phone_number = formatPhoneNumber($user->phone_number);
                            $smsoutbox->user_agent = getUserAgent();
                            $smsoutbox->src_ip = getIp();
                            $smsoutbox->src_host = getHost();
                            $smsoutbox->created_by = $user_id;
                            $smsoutbox->updated_by = $user_id;
                            $smsoutbox->save();

                        } else {

                            $errors[] = $response->message;

                        }

                    } else {
                        
                        //create new scheduled sms outbox
                        $schedulesmsoutbox = new ScheduleSmsOutbox();
                        $schedulesmsoutbox->message = $request->sms_message;
                        $schedulesmsoutbox->user_id = $x;
                        $schedulesmsoutbox->company_id = $request->company_id;
                        $schedulesmsoutbox->sms_user_name = $usr;
                        $schedulesmsoutbox->phone_number = formatPhoneNumber($user->phone_number);
                        $schedulesmsoutbox->user_agent = getUserAgent();
                        $schedulesmsoutbox->src_ip = getIp();
                        $schedulesmsoutbox->src_host = getHost();
                        $schedulesmsoutbox->created_by = $user_id;
                        $schedulesmsoutbox->updated_by = $user_id;
                        $schedulesmsoutbox->save();                    

                    }

                } 
                
                Session::flash('success', 'SMS successfully sent/ scheduled');
                return redirect()->back();
            
            }

        }
        //dd('hell');

        //send back
        Session::flash('error', "You dont have an active SMS account. Please contact pendomedia.");
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
        
        //get details for this smsoutbox
        $smsoutbox = SmsOutbox::where('id', $id)
                 ->with('company')
                 ->first();
        
        return view('smsoutbox.show', compact('smsoutbox'));

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
            $companies = $user->company;
        }
        
        return view('smsoutbox.edit')->withGroup($group)->withCompanies($companies);

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
        return redirect()->route('smsoutbox.show', $group->id);

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
