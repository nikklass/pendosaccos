<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function getUserList(){
        $data = User::orderBy('first_name', 'asc')->get();
        return response(['data' => $data], 200);
    }

    /*get single user*/
    public function getUser($id){

        $data = User::where('id', $id)
                //->with('images')
                ->first();

        return response(['data' => $data], 200);

    }

    



    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /*Handle forgot password request*/
    public function forgotPassword(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response(['data' => 'Check if email is corrects'], 403);
        }

        $token = Token::create([
            'user_id' => $user->id,
            'token' => uniqid,
            'expire_at' => Carbon::now()->addHout()
        ]);

        Mail::to($user)->send(new ForgotPassword($token, $request));

        return response(['data' => 'Email sent'], 200);
    
    }

    /*Handle reset password request*/
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response(['data' => $validator->errors()], 433);
        }

        //okay
        $token = $request->input('token');
        $dbToken = DB::table('tokens')
            ->where('token', $token)
            ->where('expire_at', '>', Carbon::now())
            ->first();

        //if token is wrong or expired
        if (!$dbToken) {
            return response(['data' => 'Wrong Token'], 403);
        }

        //all is ok
        $user = User::where('id', $dbToken->user_id)->first();
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response(['data' => 'Password changed'], 200);

    }

}
