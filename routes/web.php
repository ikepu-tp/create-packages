<?php

use App\Http\Controllers\ProfileController;
use ikepu_tp\ActivityLog\app\Http\Controllers\ActivityLogController;
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
    return view('welcome', ["data" => "data"]);
})->name("home");
Route::get('/api', function () {
    return response()->json(["this" => "api"]);
})->name("api");

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get("/activity-log", [\ikepu_tp\ActivityLog\app\Http\Controllers\ActivityLogController::class, "index"])->name("activity-log.index");
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/react', function () {
    return view('react');
})->name('react');


Route::get("activity-log", [ActivityLogController::class, "index"])->middleware(["auth:" . config("activity-log.guard")])->name("activity-log.index");
