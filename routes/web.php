<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/register', [UserController::class, 'register']);
Route::post('/register', [UserController::class, 'saveUser'])->name('auth.register');
Route::post('/login', [UserController::class, 'loginUser'])->name('auth.login');
Route::get('/dashboard', [UserController::class, 'home'])->name('layouts.home');


Route::group(['middleware' => ['LoginCheck']], function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('layouts.dashboard');
    Route::get('/home', [UserController::class, 'home']);
    Route::get('/', [UserController::class, 'index']);
    Route::get('/lessons', [UserController::class, 'lessonRecords']);
    Route::post('/lessons', [UserController::class, 'addLesson'])->name('layouts.lessons');
    Route::get('/viewlesson/{id}', [UserController::class, 'viewLesson']);
    Route::post('/viewlesson', [UserController::class, 'editDeleteLesson'])->name('layouts.viewlesson');
    Route::get('/certificates', [UserController::class, 'certificates']);
    Route::get('/viewcert/{id}', [UserController::class, 'viewCert']);
    Route::get('/logout', [UserController::class, 'logout'])->name('auth.logout');
});