<?php

namespace App\Http\Controllers;

use App\Company;
use App\Group;
use App\SmsOutbox;
use App\ScheduleSmsOutbox;
use App\User;
use Session;
use Excel;

use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class SmsOutboxController extends Controller
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
        $smsoutboxes = SmsOutbox::orderBy('id', 'desc')->paginate(10);
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
        $user = auth()->user();
        //if user is superadmin, show all companies, else show a user's companies
        if ($user->hasRole('superadministrator')){
            $groups = Group::all();
            $users = User::all();
        } else {
            $groups = Group::all();
            $users = User::all();
        }
        //get account sms balance
        /*$src = \Config::get('constants.bulk_sms.src');
        $usr = \Config::get('constants.bulk_sms.usr');
        $pass = \Config::get('constants.bulk_sms.pass');

        $response = getBulkSMSData($usr);*/
        //dd($response);

        return view('smsoutbox.create')
               ->withGroups($groups)
               ->withUsers($users);

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

        $this->validate($request, [
            'sms_message' => 'required'        
        ]);

        $src = \Config::get('constants.bulk_sms.src');
        $usr = \Config::get('constants.bulk_sms.usr');
        $pass = \Config::get('constants.bulk_sms.pass');

        $usersSelected = explode(',', $request->usersSelected);
        $sms_message = trim($request->sms_message);
            
        //formulate sms message if excel file was loaded
        if ($request->attachContent) {

            //read sms and check for delimiters in sms box
            $matches_regex = "/\[\[(\w+)\]\]/";
            $remove_spaces_regex = "/\s+/";

            //remove all spaces
            $regex_message = preg_replace($remove_spaces_regex, ' ', $sms_message);

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
                
                //insert sms outbox data
                foreach ($data as $key => $value) {
                    
                    //init sms_message in each loop
                    $local_sms_message = $sms_message;
                    $local_phone_number = null;
                    
                    //get values from excel and map to sms_message
                    //loop thru headers and get values assigned in $data array
                    //generate the message
                    foreach ($headers as $key => $header) {
                        
                        //get the phone number
                        if ($header == "phone_number") {
                            $local_phone_number = $value[$header];
                        }

                        //check if $header is in sms_message, 
                        //assign to markers present in sms
                        if (in_array($header, $match_results)) {
                            //get the items value from excel file
                            $item_value = $value[$header];
                            $item_value_regex = "/\[\[$header\]\]/";
                            //replace sms_message placeholder with this value
                            $local_sms_message = preg_replace($item_value_regex, $item_value, $local_sms_message);
                        }

                    }
                    //end generate the message

                    // send sms
                    if ($request->sendSmsCheckBox == 'now') {

                        $params['usr'] = $usr;
                        $params['pass'] = $pass;
                        $params['src'] = $src;
                        $params['phone_number'] = $local_phone_number;
                        $params['sms_message'] = $local_sms_message;

                        $response = sendSms($params);

                        //find user who owns phone number 
                        $local_user_id = null;
                        if ($local_phone_number) {
                            $local_user = User::where('phone_number', $local_phone_number)->first();
                            if ($local_user) {
                                $local_user_id = $local_user->id;
                            }
                        }                        

                        if ($response['mobile']) {

                            //create new outbox
                            $smsoutbox = new SmsOutbox();
                            $smsoutbox->message = $local_sms_message;
                            $smsoutbox->short_message = reducelength($local_sms_message);
                            $smsoutbox->user_id = $local_user_id;
                            $smsoutbox->phone_number = $local_phone_number;
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
                        $schedulesmsoutbox->user_id = $local_user_id;
                        $schedulesmsoutbox->phone_number = $local_phone_number;
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

            } else {
                //throw an error msg here
                //please select excel file and create markers in your sms message with [[]] tags
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

                    $response = sendSms($params);

                    //dd($response);

                    if (!$response['error']) {
                        
                        //create new outbox
                        $smsoutbox = new SmsOutbox();
                        $smsoutbox->message = $request->sms_message;
                        $smsoutbox->short_message = reducelength($request->sms_message,100);
                        $smsoutbox->user_id = $x;
                        $smsoutbox->phone_number = $user->phone_number;
                        $smsoutbox->user_agent = getUserAgent();
                        $smsoutbox->src_ip = getIp();
                        $smsoutbox->src_host = getHost();
                        $smsoutbox->created_by = $user_id;
                        $smsoutbox->updated_by = $user_id;
                        $smsoutbox->save();

                        Session::flash('success', 'SMS successfully sent');
                        return redirect()->route('smsoutbox.index');

                    } else {

                        $errors['sms'] = $response->message;
                        return redirect()->back()->withErrors($errors);

                    }

                } else {
                    
                    //create new scheduled sms outbox
                    $schedulesmsoutbox = new ScheduleSmsOutbox();
                    $schedulesmsoutbox->message = $request->sms_message;
                    $schedulesmsoutbox->user_id = $x;
                    $schedulesmsoutbox->phone_number = $user->phone_number;
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
            $companies = $user->companies;
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
