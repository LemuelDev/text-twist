<?php

namespace App\Http\Controllers;

use App\Mail\ApproveEmail;
use App\Mail\DeactivateEmail;
use App\Models\Level;
use App\Models\User;
use App\Models\Userprofile;
use App\Models\Word;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

     public function download(Request $request)
{


    // 3. Pass the appointments and date range to the view.
    $currentDate = Carbon::now()->format('F j, Y');

    $leaderboards = Userprofile::where('user_type', 'player')
        ->orderBy('highscore', 'desc')
        ->get();

    $pdf = Pdf::loadView('reports.leaderboards_table', compact('leaderboards', 'currentDate'));
    
    // 4. Create a dynamic filename for the PDF.
    $filename = 'Leaderboards_' . $currentDate . '.pdf';

    // 5. Download the PDF.
    return $pdf->download($filename);
}
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

        $message = "Your account is finally approved. You can now login and play the game!";
        Mail::to($id->email)->send(new ApproveEmail($message));

        return redirect()->route("admin.pendingUsers")->with("success", "User status updated successfully.");
      
    }

    public function pending(Userprofile $id) {
        $id->isPending = "pending";
        $id->update();

        
        $message = "Your account is deactivated for a while. We will update you once it is approved again. Thank you!";
        Mail::to($id->email)->send(new DeactivateEmail($message));

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
        ->orderBy('highscore', 'asc')
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

        $lastLevels = [
            'easy' => Level::where('mode', 'easy')->max('level_number') ?? 0,
            'intermediate' => Level::where('mode', 'intermediate')->max('level_number') ?? 0,
            'hard' => Level::where('mode', 'hard')->max('level_number') ?? 0,
        ];

        $words = Word::whereHas('level', function ($query) {
            $query->where('mode', 'easy');
        })->paginate(4);

        // Pass both the paginated words and the lastLevels array to your view
        return view("admin.questions", compact('words', 'lastLevels'));
    }

     public function intermediate() {

        $lastLevels = [
            'easy' => Level::where('mode', 'easy')->max('level_number') ?? 0,
            'intermediate' => Level::where('mode', 'intermediate')->max('level_number') ?? 0,
            'hard' => Level::where('mode', 'hard')->max('level_number') ?? 0,
        ];

        $words = Word::whereHas('level', function ($query) {
            $query->where('mode', 'intermediate');
        })->paginate(4);

        // Pass both the paginated words and the lastLevels array to your view
        return view("admin.questions", compact('words', 'lastLevels'));
    }

     public function hard() {

        $lastLevels = [
            'easy' => Level::where('mode', 'easy')->max('level_number') ?? 0,
            'intermediate' => Level::where('mode', 'intermediate')->max('level_number') ?? 0,
            'hard' => Level::where('mode', 'hard')->max('level_number') ?? 0,
        ];

        $words = Word::whereHas('level', function ($query) {
            $query->where('mode', 'hard');
        })->paginate(4);

        // Pass both the paginated words and the lastLevels array to your view
        return view("admin.questions", compact('words', 'lastLevels'));
    }


    public function deleteWord(Word $word){
        $word->delete();

        return redirect()->route("admin.questions")->with("success", "Word deleted successfully!");
    }

    public function addWord(Request $request) {
        $request->validate([
            'level_number' => 'required',
            'question' => 'required',
            'words' => 'required|array',
            'meanings' => 'required|array',
            'mode_select' => 'required'
        ]);
    
        $level = Level::create([
            'level_number' => $request->level_number,
            'question' => $request->question,
            'mode' => $request->mode_select,
        ]);
    
        if(count($request->words ) > 0){
        foreach ($request->words as $index => $word) {
            Word::create([
                'level_id' => $level->id,
                'word' => strtolower($word),
                'meaning' => $request->meanings[$index],
            ]);
        }
        }else{
            Word::create([
                'level_id' => $level->id,
                'word' => strtolower($request->words[0]),
                'meaning' => $request->meanings[0],
            ]);
        }

        return redirect()->route("admin.questions")->with("success", "Word added successfully!");
    }

    public function editWord($id)
{
    
    $level = Level::with('words')->findOrFail($id);
    return view('admin.trackQuestions', compact('level'));
}


public function updateWord(Request $request, Level $id)
{
    // Define expected word/meaning counts per mode for validation
    $modeWordCounts = [
        'easy' => 1,
        'intermediate' => 2,
        'hard' => 3,
    ];

    // Get the expected count for the current id's mode
    $expectedCount = $modeWordCounts[$id->mode] ?? 1; // Default to 1 if mode somehow missing

    $validatedData = $request->validate([
        // id_number is readonly, so usually not validated for unique here in update.
        // If it can be changed, adjust validation.
        'question' => ['required', 'string', 'max:255'],
        // Validate words and meanings arrays to ensure they match the expected count for the mode
        'words' => ['required', 'array', 'size:' . $expectedCount],
        'words.*.id' => ['nullable', 'integer', 'exists:words,id'], // ID for existing words
        'words.*.word' => ['required', 'string', 'max:50'],
        'words.*.meaning' => ['required', 'string', 'max:255'],
    ]);

    // 1. Update the id's question
    $id->update([
        'question' => $validatedData['question'],
        // 'mode' and 'level_number' typically won't be updated here as they define the level itself.
        // If you need to allow changing the mode of a level, that's a more complex operation
        // as it affects the number of words. For now, assume they are fixed.
    ]);

    // 2. Update or create associated Word records
    foreach ($validatedData['words'] as $wordData) {
        // If an ID is present, it's an existing word to update
        if (isset($wordData['id'])) {
            Word::where('id', $wordData['id'])
                ->where('level_id', $id->id) // Ensure the word belongs to this level
                ->update([
                    'word' => strtolower($wordData['word']),
                    'meaning' => $wordData['meaning'],
                ]);
        } else {
             return redirect()->route("admin.questions")->with("failed", "Update couldn't save!");
        }
    }

    // Handle deletion of words if the number of submitted words is less than original
    // This scenario is less likely if you enforce 'size' validation for the current mode.
    // However, if an admin tries to submit fewer words than previously existed for a level's mode,
    // you'd need to delete the "extra" words. For now, assuming 'size' validation handles this.

    return redirect()->route("admin.questions")->with("success", "Level updated successfully!");
}


}
