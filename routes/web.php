<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
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


Route::post('/signup/store', [AuthController::class,'store'])->name('users.store');

Route::post('/login', [AuthController::class , 'authenticate'])->name("user.login");

Route::post('/logout', [AuthController::class , 'logout'])->name('logout');


// player routes

Route::get("/player/dashboard", [PlayerController::class, "dashboard"])->name("player.dashboard");

Route::get("/player/profile", [PlayerController::class, "profile"])->name("player.profile");

Route::get("/player/gameOver/{lvl}/{points}", [GameController::class, "gameOver"])->name('player.gameOver');

Route::get('/player/game', [GameController::class, 'game'])->name('player.newGame');

Route::post('/player/next-level', [GameController::class, 'nextLevel'])->name('player.nextLevel');




// admin routes

Route::get("/admin/approved-users", [AdminController::class, "approvedUsers"])->name("admin.approveUsers");

Route::get("/admin/pending-users", [AdminController::class, "pendingUsers"])->name("admin.pendingUsers");

Route::get("/admin/leaderboards", [AdminController::class, "leaderboards"])->name("admin.leaderboards");

Route::get("/admin/switch-to-pending/{id}", [AdminController::class, "pending"])->name("admin.pending");

Route::get("/admin/switch-to-approved/{id}", [AdminController::class, "approved"])->name("admin.approved");

Route::post("/user/delete/{user}", [AdminController::class, 'deleteUser'])->name("admin.deleteUser");

Route::get("/admin/track-user/{user}", [AdminController::class, "trackUser"])->name("admin.trackUser");

Route::get("/admin/profile", [AdminController::class, "profile"])->name("admin.profile");


Route::get("/admin/questions", [AdminController::class, "questions"])->name("admin.questions");

Route::post("/admin/add-word", [AdminController::class, "addWord"])->name("admin.addWord");

Route::post("/admin/delete-word/{word}", [AdminController::class, "deleteWord"])->name("admin.deleteWord");



