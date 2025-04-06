<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userprofile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function logout(){
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect()->route("login")->with("success","Logout Successfully");
    }

    public function authenticate(){
        
        $validated = request()->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'required' => 'All fields must be filled up', // Custom message for required fields
        ]);

         if (auth()->attempt($validated)){
        
          
            $user = auth()->user();
            if ($user->userProfile->isPending == 'pending'){

                return redirect()->route("login")->with('failed', 'Your account is still for approval.');
            }else {

                request()->session()->regenerate();

                if ($user->userProfile->user_type === 'admin') {
                 
                     return redirect()->route('admin.approveUsers');
                    
        
                } else{
                    return redirect()->route('player.dashboard');
                }
            }

        }else {
                    // Check if the username exists in the database
                $usernameExists = User::where('username', request('username'))->exists();

                if ($usernameExists) {
                    // If username exists but password is wrong
                    return redirect()->route("login")->with(  "failed" , "Incorrect password. Please try again.");
                } else {
                    // If username doesn't exist
                    return redirect()->route("login")->with(  "failed" , "Invalid Login Credentials. Please try again.");
                }
        }
        
    }

    public function store(){
        $requiredFields = ['lastname', 'firstname', 'email', 'username', 'password', 'student_number', 'year'];
    
        foreach ($requiredFields as $field) {
            if (empty(request($field))) {
                return back()->withErrors(['general' => 'All fields must be filled up.'])->withInput();
            }
        }

        $validated = request()->validate([
            "lastname" => "required|string|max:40",
            "firstname" => "required|string|max:40",
            "middlename" => "nullable|string|max:40",
            "email" => "required|email",
            "username" => "required|max:40",
            "password" => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one number
                'regex:/[@$!%*?&#]/' // must contain a special character
            ],
            "student_number" => "required|string",
            "year" => "required|string",

        ], [
            'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter, one number, and one special character.'
        ]);
        
        if (Userprofile::where('email', $validated['email'])->exists() || User::where('username', $validated['username'])->exists()) {
            return redirect()->back()->with('failed', 'This user already has an account.');
        }

        $name = $validated["lastname"] . ', ' . $validated["firstname"];
        if (!empty($validated["middlename"])) {
            $name .= ' ' . $validated["middlename"];
        }

         // Create the user profile
         $userProfile = UserProfile::create([
            "firstname" => $validated["firstname"],
            "middlename" => $validated["middlename"] ?? '',
            "lastname" => $validated["lastname"],
            "fullname"=> $name,
            "email" => $validated["email"],
            "student_number" => $validated["student_number"],
            "year" => $validated["year"],
        ]);

        // Create the user and associate it with the user profile
        User::create([
            "username" => $validated["username"],
            "password" => Hash::make($validated["password"]),
            "userprofile_id" => $userProfile->id 
        ]);
        
        return redirect()->route("login")->with("success", "Signup Complete! Wait for the Approval of the Admin.");
    }



}
