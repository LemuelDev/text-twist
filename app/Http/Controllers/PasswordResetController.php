<?php

namespace App\Http\Controllers;

use App\Mail\SendResetPassEmail;
use App\Models\PasswordResetsToken;
use App\Models\User;
use App\Models\Userprofile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
     
    public function showLinkRequestForm() {
        return view('authentication.forgot-password');
    }
   // Handle sending the password reset link
   public function sendResetLinkEmail(Request $request)
   {
       $request->validate([
        'email' => 'required|email'
        ]);

       // Find the user by email
       $user = Userprofile::where('email', $request->email)->first();

       if (!$user) {
           return back()->withErrors(['email' => 'No user found with that email address.']);
       }

       
       // Create a password reset token
       $token = Str::random(30);
       $expiresAt = Carbon::now()->addMinutes(2); // Set token expiry to 60 minutes from now

       // Save the token to the password_resets table
       PasswordResetsToken::create([
        'email' => $request->email,
        'token' => $token,
        'created_at' => Carbon::now(),
        'expires_at' => $expiresAt
       ]);

        
        Mail::to($user->email)->send(new SendResetPassEmail(route('password.reset', $token)));

       return back()->with('success', 'Password reset link sent!');
   }

   // Show the password reset form
   public function showResetForm($token)
   {
       return view('authentication.reset-password', ['token' => $token]); // Assuming a Blade template exists at resources/views/auth/passwords/reset.blade.php
   }

   // Handle the password reset
   public function reset(Request $request)
   {
    $request->validate([
        'email' => 'required|email',
        "password" => [
            'required',
            'string',
            'min:8',
            'regex:/[a-z]/', // must contain at least one lowercase letter
            'regex:/[A-Z]/', // must contain at least one uppercase letter
            'regex:/[0-9]/', // must contain at least one number
            'regex:/[@$!%*?&#]/',
             'confirmed' // must contain a special character
        ], // Laravel will look for 'password_confirmation'
        'token_user' => 'required'
    ]);

       // Find the reset record
       $passwordReset = PasswordResetsToken::where('email', $request->email)
                                     ->where('token', $request->token_user)
                                     ->first();

       if (!$passwordReset) {
           return back()->withErrors(['email' => 'Invalid email.']);
       }

       // Check if the token is expired
       if (Carbon::now()->greaterThan($passwordReset->expires_at)) {
           return back()->withErrors(['email' => 'Token has expired.']);
       }

    //    if ($request->password !== $request->confirm_password){
    //     return back()->withErrors(['password' => 'Password do not match.Try Again']);
    //     }

       // Find the user by email
       $userprof = Userprofile::where('email', $request->email)->first();
       $user = User::where('userprofile_id', $userprof->id)->first();

       if (!$userprof) {
           return back()->withErrors(['email' => 'No user found with that email address.']);
       }
       
       $user->password = Hash::make($request->password);
       $user->save();

       // Delete the password reset record
       PasswordResetsToken::where('email', $request->email)->delete();

       return redirect()->route('login')->with('success', 'Password reset successful!');
   }
}
