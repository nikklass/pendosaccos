<?php

namespace App\Http\Controllers;

use App\Company;
use App\SmsOutbox;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExcelController extends Controller
{
    
    //export sms outbox
    public function exportOutboxSmsToExcel($type) {

        //get logged in user
        $user = auth()->user();
        $company_name = null;

        //if user is superadmin, show all companies, else show a user's companies
        $companies = [];
        if ($user->hasRole('superadministrator')){
            $companies = Company::all()->pluck('id');
        } else if ($user->hasRole('administrator')) {
            if ($user->company) {
                $companies = $user->company->pluck('id');
                $company_name = $user->company->name;
            }
        }

        //get company smsoutbox
        $users = [];
        $groups = [];

        if ($companies) {

            $smsoutboxes = 

                DB::table('sms_outboxes')
                    ->join('statuses', 'sms_outboxes.status_id', '=', 'statuses.id')
                    ->select(
                                'sms_outboxes.id',
                                'sms_outboxes.message', 
                                'sms_outboxes.phone_number',
                                'statuses.name',
                                'sms_outboxes.created_at'
                            )
                    ->whereIn('sms_outboxes.company_id', $companies)
                    ->orderBy('sms_outboxes.id', 'desc')
                    ->get();

        }

        //if smsoutboxes exist
        if (count($smsoutboxes)) {

            // Initialize the array which will be passed into the Excel
            // generator.
            $smsoutboxesArray = []; 

            // Define the Excel spreadsheet headers
            $smsoutboxesArray[] = ['id', 'message','phone','status','created_at'];

            // Convert each member of the returned collection into an array,
            // and append it to the array.
            foreach ($smsoutboxes as $smsoutbox) {
                $smsoutboxesArray[] = (array)$smsoutbox;
            }

            // Generate and return the spreadsheet
            $excel_name = "sms_outbox_$company_name";
            $excel_title = "Sms Outbox - $company_name";
            $excel_desc = "Sms Outbox data for $company_name";
            $data_array = $smsoutboxesArray;
            $data_type = $type;

            //download the file
            downloadExcelFile($excel_name, $excel_title, $excel_desc, $data_array, $data_type);

        }

    }

    //export groups
    public function exportGroupsToExcel($type) {

        //get logged in user
        $user = auth()->user();
        $company_name = null;

        //if user is superadmin, show all companies, else show a user's companies
        $companies = [];
        if ($user->hasRole('superadministrator')){
            $companies = Company::all()->pluck('id');
        } else if ($user->hasRole('administrator')) {
            if ($user->company) {
                $companies = $user->company->pluck('id');
                $company_name = $user->company->name;
            }
        }

        //get company smsoutbox
        $users = [];
        $groups = [];

        if ($companies) {

            $groups = 

                DB::table('groups')
                    ->select(
                                'groups.id',
                                'groups.name', 
                                'groups.phone_number',
                                'groups.email', 
                                'groups.created_at'
                            )
                    ->whereIn('groups.company_id', $companies)
                    ->orderBy('groups.name', 'asc')
                    ->get();

        }

        //if smsoutboxes exist
        if (count($groups)) {

            // Initialize the array which will be passed into the Excel
            // generator.
            $groupsArray = []; 

            // Define the Excel spreadsheet headers
            $groupsArray[] = ['id', 'name','phone','email','created_at'];

            // Convert each member of the returned collection into an array,
            // and append it to the array.
            foreach ($groups as $group) {
                $groupsArray[] = (array)$group;
            }

            // Generate and return the spreadsheet
            $excel_name = "groups_$company_name";
            $excel_title = "Groups - $company_name";
            $excel_desc = "Groups data for $company_name";
            $data_array = $groupsArray;
            $data_type = $type;

            //download the file
            downloadExcelFile($excel_name, $excel_title, $excel_desc, $data_array, $data_type);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
