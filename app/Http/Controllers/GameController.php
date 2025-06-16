<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Userprofile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
      private function getGameDataForMode(string $mode, int $levelNumber)
    {
        // Define the number of words to select for each mode
        $wordCounts = [
            'easy' => 1,
            'intermediate' => 2,
            'hard' => 3,
        ];

        $wordsToTake = $wordCounts[$mode] ?? 1; // Default to 1 if mode isn't found

        // Get the specific Level for the given mode and level_number, eager load its words
        $level = Level::with('words')
                      ->where('mode', $mode)
                      ->where('level_number', $levelNumber)
                      ->first();

        // If the specific level is not found, you might want to:
        // 1. Redirect to a "Level not found" page.
        // 2. Default to Level 1 for that mode.
        // 3. Handle the end of levels for that mode.
        // For now, let's default to the first level if the requested one doesn't exist.
        if (!$level) {
            $level = Level::with('words')
                          ->where('mode', $mode)
                          ->where('level_number', 1) // Try to get level 1 for this mode
                          ->firstOrFail(); // If even level 1 doesn't exist, this will throw an error
                                           // Consider a custom error or redirect if no levels exist at all.
        }

        // Shuffle and get the required number of words from the level
        $selectedWords = $level->words->shuffle()->take($wordsToTake);

        // Prepare the words for the client-side game (shuffled characters)
        $shuffledWords = $selectedWords->map(function ($word) {
            return $word->word; // Or shuffle characters here if 'word' needs scrambling on JS side
        });

        // Original words + meanings (for checking answers and displaying info)
        $wordMeanings = $selectedWords->map(function ($word) {
            return [
                'word' => $word->word,
                'meaning' => $word->meaning,
            ];
        });

        // Fetch user-specific data
        $userProfile = auth()->user()->userProfile; // Assuming authenticated user and has userProfile relation
        $highscore = $userProfile->highscore;
        $lvl_cleared = $userProfile->lvl_cleared; // This might need to be mode-specific later

        $question = $level->question; // The question for the current level

        return compact('shuffledWords', 'wordMeanings', 'highscore', 'lvl_cleared', 'levelNumber', 'question', 'mode');
    }

    /**
     * Displays the game for Easy mode.
     * @param int $levelNumber The current level number for Easy mode.
     */
    public function easy(int $levelNumber = 1) // Default to level 1 if not provided
    {
        $gameData = $this->getGameDataForMode('easy', $levelNumber);
        return view('player.game', $gameData);
    }

    /**
     * Displays the game for Intermediate mode.
     * @param int $levelNumber The current level number for Intermediate mode.
     */
    public function intermediate(int $levelNumber = 1) // Default to level 1 if not provided
    {
        $gameData = $this->getGameDataForMode('intermediate', $levelNumber);
        return view('player.game', $gameData);
    }

    /**
     * Displays the game for Hard mode.
     * @param int $levelNumber The current level number for Hard mode.
     */
    public function hard(int $levelNumber = 1) // Default to level 1 if not provided
    {
        $gameData = $this->getGameDataForMode('hard', $levelNumber);
        return view('player.game', $gameData);
    }

     private function getModeWordCounts()
    {
        return [
            'easy' => 1,
            'intermediate' => 2,
            'hard' => 3,
        ];
    }

    /**
     * Determines the next level's data for a specific mode.
     *
     * @param string $mode The current game mode (e.g., 'easy', 'intermediate', 'hard').
     * @param int $currentLvl The level number the player just completed.
     * @return \Illuminate\Http\JsonResponse
     */
    public function nextLevel(string $mode, int $currentLvl) // Added $mode parameter
    {
        $wordCounts = $this->getModeWordCounts();
        $wordsToTake = $wordCounts[$mode] ?? 1; // Default to 1 if mode isn't recognized

        // 1. Get the highest level_number for the SPECIFIC MODE
        $maxLevel = Level::where('mode', $mode)->max('level_number') ?? 0;

        // 2. Determine the next level. If max level for this mode is reached, loop back to 1.
        $nextLevelNumber = ($currentLvl + 1) <= $maxLevel ? ($currentLvl + 1) : 1;

        // 3. Get the Level and its words, filtering by mode and the determined next level number
        $level = Level::with('words')
                      ->where('mode', $mode) // Filter by mode
                      ->where('level_number', $nextLevelNumber)
                      ->first();
        if (!$level || $level->words->isEmpty()) {
            Log::error("No level or no words found for mode: {$mode}, level: {$nextLevelNumber}");
            // You might return an error status here or empty data
            // return response()->json(['error' => 'No more levels or words found'], 404);
        }

        $selectedWords = $level->words->shuffle()->take($wordsToTake); // Is $wordsToTake correct for hard (3)?
        // Debug:
        Log::info("Next Level: {$nextLevelNumber}, Mode: {$mode}, Selected Words Count: " . $selectedWords->count());

        if (!$level) {
            // Fallback: If for some reason the calculated next level doesn't exist,
            // try to get Level 1 for this mode. If even that fails, it's an issue.
            $level = Level::with('words')
                          ->where('mode', $mode)
                          ->where('level_number', 1)
                          ->firstOrFail(); // Using firstOrFail() to ensure a level is always found or an error is thrown
        }

        // 4. Shuffle and get the correct number of words based on the mode
        $selectedWords = $level->words->shuffle()->take($wordsToTake);

        // Prepare data for JSON response
        $shuffledWords = $selectedWords->map(function ($word) {
            return $word->word;
        });

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
            'nextLevel' => $nextLevelNumber,
            'question' => $question,
            'mode' => $mode // Also useful to send the mode back to frontend
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
