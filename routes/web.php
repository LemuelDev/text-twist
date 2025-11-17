<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('homepage');
});

Route::get('/login', function () {
    return view('authentication/login');
})->name("login");


Route::get('/signup', function () {
    return view('authentication/signup');
})->name("signup");

Route::get('password/reset', [PasswordResetController::class, 'showLinkRequestForm'])
    ->name('password.request');

// Handle sending the password reset link
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// Show the form to reset the password
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.reset');

// Handle the password reset form submission
Route::post('password/reset/', [PasswordResetController::class, 'reset'])
    ->name('password.update');


Route::post('/signup/store', [AuthController::class,'store'])->name('users.store');

Route::post('/login', [AuthController::class , 'authenticate'])->name("user.login");

Route::post('/logout', [AuthController::class , 'logout'])->name('logout');


// player routes

Route::get("/player/dashboard", [PlayerController::class, "dashboard"])->name("player.dashboard");

Route::get("/player/profile", [PlayerController::class, "profile"])->name("player.profile");

Route::get("/player/profile/edit", [PlayerController::class, "editProfile"])->name("player.editProfile");

Route::post("/player/profile/update", [PlayerController::class, "updateProfile"])->name("player.updateProfile");

Route::get('/player/profile/editPassword/', [PlayerController::class, 'editPassword'])->name('player.editPassword');

Route::post('/player/profile/updatePassword/', [PlayerController::class, 'updatePassword'])->name('player.updatePassword');

Route::get("/player/gameOver/{lvl}/{points}", [GameController::class, "gameOver"])->name('player.gameOver');

Route::get('/player/game/easy/{levelNumber?}', [GameController::class, 'easy'])->name('player.newGame');

Route::get('/player/game/intermidiate/{levelNumber?}', [GameController::class, 'intermediate'])->name('player.intermidiate');

Route::get('/player/game/hard/{levelNumber?}', [GameController::class, 'hard'])->name('player.hard');

Route::get('/game/{mode}/next-level/{currentLvl}', [GameController::class, 'nextLevel'])->name('player.nextLevel');




// admin routes

Route::get('/admin/leaderboards/download/all/', [AdminController::class, 'download'])->name('admin.download');

Route::get("/admin/approved-users", [AdminController::class, "approvedUsers"])->name("admin.approveUsers");

Route::get("/admin/pending-users", [AdminController::class, "pendingUsers"])->name("admin.pendingUsers");

Route::get("/admin/leaderboards", [AdminController::class, "leaderboards"])->name("admin.leaderboards");

Route::get("/admin/switch-to-pending/{id}", [AdminController::class, "pending"])->name("admin.pending");

Route::get("/admin/switch-to-approved/{id}", [AdminController::class, "approved"])->name("admin.approved");

Route::post("/user/delete/{user}", [AdminController::class, 'deleteUser'])->name("admin.deleteUser");

Route::get("/admin/track-user/{user}", [AdminController::class, "trackUser"])->name("admin.trackUser");

Route::get("/admin/profile", [AdminController::class, "profile"])->name("admin.profile");

Route::get("/admin/profile/edit", [AdminController::class, "editProfile"])->name("admin.editProfile");

Route::post("/admin/profile/update", [AdminController::class, "updateProfile"])->name("admin.updateProfile");

Route::get('/admin/profile/editPassword/', [AdminController::class, 'editPassword'])->name('admin.editPassword');

Route::post('/admin/profile/updatePassword/', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');

Route::get("/admin/questions/easy", [AdminController::class, "questions"])->name("admin.questions");

Route::get("/admin/questions/intermediate", [AdminController::class, "intermediate"])->name("admin.intermediate");

Route::get("/admin/questions/hard", [AdminController::class, "hard"])->name("admin.hard");

Route::post("/admin/add-word", [AdminController::class, "addWord"])->name("admin.addWord");

Route::get("/admin/add-word/edit/{id}", [AdminController::class, "editWord"])->name("admin.editWord");

Route::post("/admin/add-word/update/{id}", [AdminController::class, "updateWord"])->name("admin.updateWord");

Route::post("/admin/delete-word/{word}", [AdminController::class, "deleteWord"])->name("admin.deleteWord");



