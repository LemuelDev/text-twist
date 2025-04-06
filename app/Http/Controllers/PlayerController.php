<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class PlayerController extends Controller
{
    //
    
    public function dashboard(){
        return view("player.home");
    }

    public function profile(){
        return view("player.profile");
    }   

    
    public function editProfile() {
        return view ("player.trackProfile");
    }



    public function updateProfile()
    {
        $validator = Validator::make(request()->all(), [
            "lastname" => "required|string|max:40",
            "firstname" => "required|string|max:40",
            "middlename" => "nullable|string|max:40",
            "username" => "required|string",
            "email" => "required|string",
            "student_number" => "required|string",
            "year" => "required|string",
        ], [
            "year.required" => "The section field is required.",
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput() // keep old values in form
                ->with('failed', 'Please fill out all required fields correctly.');
        }
    
        $validated = $validator->validated();
    
        $user = User::find(auth()->id());
    
        $user->update([
            "username" => $validated["username"]
        ]);
    
        $user->userProfile()->update([
            "firstname" => $validated["firstname"],
            "middlename" => $validated["middlename"] ?? '',
            "lastname" => $validated["lastname"],
            "student_number" => $validated["student_number"],
            "year" => $validated["year"],
            "email" => $validated["email"]
        ]);
    
        return redirect()->route("player.profile")->with("success", "Profile updated successfully!");
    }
    
    

    public function editPassword() {
        return view ("player.trackPassword");
    }

    public function updatePassword() {
        try {
            
            $validation = request()->validate([
                "current_password" => "required|string",
                "new_password" => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[a-z]/', // must contain at least one lowercase letter
                    'regex:/[A-Z]/', // must contain at least one uppercase letter
                    'regex:/[0-9]/', // must contain at least one number
                    'regex:/[@$!%*?&#]/',
                    'confirmed'
                ],
                 // Optional field with validation for image file
            ], [
                'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter, one number, and one special character.',
            ]);

            $user = User::where('id', auth()->user()->id)->first();
               // Check if the current password matches the user's stored password
                if (!Hash::check($validation["current_password"], $user->password)) {
                    return redirect()->back()
                        ->with('failed', 'The current password does not match our records.');
                };
                
                $user->update([
                   "password" => Hash::make($validation["new_password"]), 
                ]);

            return redirect()->route("player.profile")->with("success", "Password updated successfully");

        }catch(\Illuminate\Validation\ValidationException $e){
            return redirect()->back()
            ->withErrors($e->errors())
            ->with('failed', 'Please fill out all required fields correctly.');
        }
    }
    
    public function logout(){
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect()->route("login")->with("success","Logout Successfully");
    }


}
