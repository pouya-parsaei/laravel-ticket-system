<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\TicketController;
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

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::middleware(['guest:web', 'guest:admin'])->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register-form');
    Route::post('register', [RegisterController::class, 'store'])->name('register');

    Route::get('login', [LoginController::class, 'create'])->name('login-form');
    Route::post('login', [LoginController::class, 'store'])->name('login');
});

Route::middleware('auth:web')->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:web', 'guest:admin'])->group(function () {
        Route::get('register', [AdminController::class, 'showRegisterationForm'])->name('register.form');
        Route::post('register', [AdminController::class, 'register'])->name('register');
        Route::get('login', [AdminController::class, 'showLoginForm'])->name('login.form');
        Route::post('login', [AdminController::class, 'login'])->name('login');
    });

    Route::middleware('auth:web,admin')->group(function () {
        Route::get('logout', [AdminController::class, 'logout'])->name('logout');
    });


});

Route::middleware('auth:web,admin')->group(function () {

    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('create', [TicketController::class, 'create'])->name('create');
        Route::post('', [TicketController::class, 'store'])->name('store');
        Route::get('',[TicketController::class,'index'])->name('index');
        Route::get('{ticket}/close',[TicketController::class,'close'])->name('close');
        Route::get('{ticket}',[TicketController::class,'show'])->name('show');
        Route::post('{ticket}/reply',[ReplyController::class,'store'])->name('reply.store');

    });
});
