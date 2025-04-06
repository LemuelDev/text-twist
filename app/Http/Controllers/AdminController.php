<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userprofile;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function approvedUsers() {

        $query = Userprofile::where('isPending', 'approved')
        ->where('user_type', 'player')
        ->orderBy('created_at', 'desc');

        
        if (request()->has('search')) {
            $searchQuery = request()->get('search');
            $query->where('fullname', 'like', '%' . $searchQuery . '%');
        }

        $users = $query->paginate(5);
        return view("admin.users", compact("users"));
    }

    public function approved(Userprofile $id) {
      
        $id->isPending = "approved";
        $id->update();
        return redirect()->route("admin.pendingUsers")->with("success", "User status updated successfully.");
      
    }

    public function pending(Userprofile $id) {
        $id->isPending = "pending";
        $id->update();

        return redirect()->route("admin.approveUsers")->with("success", "User status updated successfully.");
    }

    public function pendingUsers() {

        $query = Userprofile::where('isPending', 'pending')
        ->where('user_type', 'player')
        ->orderBy('created_at', 'desc');

        
        if (request()->has('search')) {
            $searchQuery = request()->get('search');
            $query->where('fullname', 'like', '%' . $searchQuery . '%');
        }

        $users = $query->paginate(5);
        return view("admin.users", compact("users"));
    }


    public function deleteUser(Userprofile $user){
        
        $user->delete();

        return redirect()->route("admin.approveUsers")->with("success", "User deleted succesfully");
    }

    public function trackUser(Userprofile $user){

        return view("admin.trackUser", compact("user"));
    }

    public function leaderboards(){

        $users = Userprofile::where('user_type', 'player')
        ->orderBy('highscore', 'desc')
        ->paginate(5);

        return view ("admin.leaderboards", compact("users"));
    }

    public function profile() {
        return view ("admin.profile");
    }

    public function editProfile() {
        return view ("admin.trackProfile");
    }

    public function updateProfile(){

            $validation = request()->validate([
                "username" => "required|string",
                "email" => "required|string",
            ]);

            $user = User::where('id', auth()->user()->userProfile->id)->first();

            $user->update([
                "username" => $validation["username"]
            ]);

            $user->userProfile()->update([
                "email" => $validation["email"]
            ]);

            return redirect()->route("admin.profile")->with("success" , "Profile updated successfully!");
    }

    public function editPassword() {
        return view ("admin.trackPassword");
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
                'email.unique' => 'The email address is already registered. Please use a different email address.' // Custom error message for unique email
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

            return redirect()->route("admin.profile")->with("success", "Password updated successfully");

        }catch(\Illuminate\Validation\ValidationException $e){
            return redirect()->back()
            ->withErrors($e->errors())
            ->with('failed', 'Please fill out all required fields correctly.');
        }
    }

    public function questions() {

        $words = Word::orderBy('id', 'asc')
        ->paginate(6);

        return view ("admin.questions", compact('words'));
    }

    public function deleteWord(Word $word){
        $word->delete();

        return redirect()->route("admin.questions")->with("success", "Word deleted successfully!");
    }

    public function addWord() {
        $validated = request()->validate([
            "word" => "required|string"
        ]);

        $uppercaseWord = strtoupper($validated["word"]);

        if (Word::where('words', $uppercaseWord)->exists()) {
            return redirect()->back()->with('failed', 'This word already exists!');
        }

        Word::create([
            "words" => $uppercaseWord
        ]);

        return redirect()->route("admin.questions")->with("success", "Word added successfully!");
    }
}
