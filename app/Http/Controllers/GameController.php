<?php

namespace App\Http\Controllers;

use App\Models\Userprofile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function game()
    {
        // Get 3 random words from the database
        $words = DB::table('words')->inRandomOrder()->limit(3)->pluck('words')->toArray();

        $highscore = auth()->user()->userProfile->highscore;
        $lvl_cleared = auth()->user()->userProfile->lvl_cleared;

        return view('player.game', compact('words', 'highscore', 'lvl_cleared'));
    }

    public function nextLevel()
    {
        
        $newWords = DB::table('words')->inRandomOrder()->limit(3)->pluck('words')->toArray();

        return response()->json(['words' => $newWords]);
    }

    public function gameOver($lvl, $points) {
        $userProfile = auth()->user()->userProfile;
    
        if ($points > intval($userProfile->highscore)) {
            $userProfile->update([
                "highscore" => $points
            ]);
        }
    
        if ($lvl > intval($userProfile->lvl_cleared)) {
            $userProfile->update([
                "lvl_cleared" => $lvl
            ]);
        }
    
        return redirect()->route('player.dashboard');
    }
    


}
