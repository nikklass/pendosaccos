<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Loan;
use App\User;
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

        $user = auth()->user();

        //if user is superadmin, show all groups, else show a user's groups
        $groups = [];
        if ($user->hasRole('superadministrator')){
            $groups = Group::all()->pluck('id');
        } else {
            if ($user->group) {
                $groups[] = $user->group->id;
            }
        }

        $groups = Group::whereIn('id', $groups)
                 ->orderBy('name', 'asc')
                 //->with('group')
                 ->paginate(10);
        //dd($groups, $user);

        return view('groups.index')
            ->withUser($user)
            ->withGroups($groups);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
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
            'email' => 'sometimes|email',
            'phone_number' => 'sometimes|max:13'
        ]);

        $phone_number = '';
        if ($request->phone_number) {
            if (!isValidPhoneNumber($request->phone_number)){
                $message = config('constants.error.invalid_phone_number');
                $errors['phone_number'] = $message;
                Session::flash('error', $message);
                return redirect()->back()->withErrors($errors)->withInput();
            }
            $phone_number = formatPhoneNumber($request->phone_number);
        }

        $group = new Group();
        $group->name = $request->name;
        $group->phone_number = $phone_number;
        $group->description = trim($request->description);
        $group->email = $request->email;
        $group->physical_address = trim($request->physical_address);
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
                 ->first();

        //get group members
        $users = $group->users()->paginate(10);

        //get groups loans
        $groups_loans = Loan::selectRaw('sum(loan_balance) loan_balance')
            ->where('group_id', $id)
            ->first();

        return view('groups.show', compact('users', 'group', 'groups_loans'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $user = auth()->user();

        $group = Group::where('id', $id)
                 ->first();
        
        return view('groups.edit')
            ->withGroup($group)
            ->withUser($user);

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
            'group_name' => 'required|max:255',
            'phone_number' => 'sometimes|max:13,phone_number,'.$id,
            'email' => 'sometimes|email',
            'group_id' => 'required|max:255'
        ]);
        //dd($request);

        $phone_number = '';
        if ($request->phone_number) {
            if (!isValidPhoneNumber($request->phone_number)){
                $message = config('constants.error.invalid_phone_number');
                Session::flash('error', $message);
                return redirect()->back()->withInput();
            }
            $phone_number = formatPhoneNumber($request->phone_number);
        }

        $group = Group::findOrFail($id);
        $group->name = $request->group_name;
        $group->phone_number = $phone_number;
        $group->description = trim($request->description);
        $group->email = $request->email;
        $group->physical_address = trim($request->physical_address);
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
