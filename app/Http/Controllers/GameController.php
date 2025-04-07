<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Userprofile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function game()
    {
        $levelNumber = 1;
    
        // Get Level 1 with its words
        $level = Level::with('words')->where('level_number', $levelNumber)->first();
    
        if (!$level) {
            $level = Level::with('words')->where('level_number', 1)->first();
        }
    
        // Shuffle and get 3 words
        $selectedWords = $level->words()->inRandomOrder()->take(3)->get();

        $shuffledWords = $selectedWords->map(function ($word) {
            return $word->word;
        });
        
        
        // Original words + meanings (kept for backend or for showing after correct answer)
        $wordMeanings = $selectedWords->map(function($word) {
            return [
                'word' => $word->word,
                'meaning' => $word->meaning,
            ];
        });
    
        $highscore = auth()->user()->userProfile->highscore;
        $lvl_cleared = auth()->user()->userProfile->lvl_cleared;
        $question = $level->question;

    
        return view('player.game', compact('shuffledWords', 'wordMeanings', 'highscore', 'lvl_cleared', 'levelNumber', 'question'));
    }
    

    public function nextLevel($lvl)
{
    // Get the highest level_number from the words table
    $maxLevel = DB::table('levels')->max('level_number');

    // Determine the next level, go back to 1 if max level is reached
    $nextLevel = ($lvl + 1) <= $maxLevel ? $lvl + 1 : 1;

    // Get the level and its words
    $level = Level::with('words')->where('level_number', $nextLevel)->first();


    if (!$level) {
        // Fallback to Level 1
        $level = Level::with('words')->where('level_number', 1)->first();
    }

    // Shuffle and get 3 words
    $selectedWords = $level->words()->inRandomOrder()->take(3)->get();

    $shuffledWords = $selectedWords->map(function ($word) {
        return $word->word;
    });

    // Original words + meanings for reveal upon solving
    $wordMeanings = $selectedWords->map(function($word) {
        return [
            'word' => $word->word,
            'meaning' => $word->meaning,
        ];
    });

    $question = $level->question;

    // Return everything as JSON for frontend use
    return response()->json([
        'shuffledWords' => $shuffledWords,
        'wordMeanings' => $wordMeanings,
        'nextLevel' => $nextLevel,
        'question' => $question
    ]);
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
