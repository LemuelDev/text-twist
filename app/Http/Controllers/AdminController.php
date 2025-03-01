<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userprofile;
use App\Models\Word;
use Illuminate\Http\Request;

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
