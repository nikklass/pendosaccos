<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationForm;
use App\Http\Requests\RegistrationRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    
    /*create a new user*/
    public function addUser(RegistrationForm $form){

        $form->persist();

        //return result as json
        return response()->json($this->content, 200); 
        
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
    
}
