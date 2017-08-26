<?php

namespace App\Http\Controllers;

use App\Group;
use App\Services\User\UserImport;
use App\TempTable;
use App\User;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class UserImportController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bulk-users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $user = auth()->user();

        //if user is superadmin, show all groups, else show a user's groups
        $groups = [];
        if ($user->hasRole('superadministrator')){
            $groups = Group::all();
        } else if ($user->hasRole('administrator')) {
            if ($user->group) {
                $groups[] = $user->group;
            }
        }

        //get user data
        $userData = User::where('id', $user->id)
                    ->with('group')
                    ->first();

        return view('bulk-users.create')
            ->withGroups($groups)
            ->withUser($userData);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, UserImport $userImport)
    {

        $user_id = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'import_file' => 'required',
            'group_id' => 'required',
            
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('import_file')) {
            
            $group_id = $request->group_id;
            $path = $request->file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();

            if (!empty($data) && $data->count()) {
                
                $errors = [];

                //toarray
                $arrdata = $data->toArray();

                if (!$userImport->checkImportData($arrdata, $group_id))
                {
                    Session::flash('error_row_id', $userImport->getErrorRowId());
                    Session::flash('valid_row_id', $userImport->getValidRowId());
                    return redirect()->back()->withInput();
                }

                $count = count($data);

                //if all is ok, create users
                $userImport->createUsers($data, $group_id);
                
            }

            Session::flash('success', 'Successfully inserted ' . $count . ' users');
            return redirect()->back();

        }

    }

    //get import data
    public function getImportData($id)
    {
        $data = TempTable::where('uuid', $id)->first();

        if (!$data) {
            abort(400, "Cannot find import data");
        }

        if ($data->user_id != auth()->user()->id) {
            abort(403, "Access Denied");
        }

        $data = unserialize($data->data);
        $header = [];

        foreach ($data[0] as $key => $value) {
            $header[] = $key;
        }

        if (!file_exists(public_path('download'))) {
            mkdir(public_path('download'), 0755, true);
        }

        $filename = time() . ".csv";
        $handle = fopen(public_path('download/' . $filename), 'w+');
        fputcsv($handle, $header);

        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return response()->download(public_path('download/' . $filename), $filename, $headers);

    }

    //get incomplete data
    public function getIncompleteData($id, UserImport $userImport)
    {
        
        //get logged in user's company id
        $company_id = null;
        if (auth()->user()->company) {
            $company_id = auth()->user()->company->id;
        }

        $data = TempTable::where('uuid', $id)->first();

        if (!$data) {
            abort(400, "Cannot find import data");
        }

        if ($data->user_id != auth()->user()->id) {
            abort(403, "Access Denied");
        }

        $data = unserialize($data->data);
        $header = [];

        $count = count($data);

        foreach ($data[0] as $key => $value) {
            $header[] = $key;
        }

        $userImport->createUsers($data, $company_id);

        Session::flash('success', 'Successfully inserted ' . $count . ' users');
        return redirect()->back();

    }

}
