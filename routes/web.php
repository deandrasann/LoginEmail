<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\sendEmailController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

// Route ke halaman welcome (homepage)
Route::get('/', function () {
    return view('welcome');
});

// Routes untuk BukuController
// Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
// Route::get('/send-email', [sendEmailController::class, 'index'])->name('send.email');
// Route::post('/post-email', [SendEmailController::class, 'store'])->name('post-email');

// Routes untuk LoginRegisterController
Route::controller(LoginRegisterController::class)->group(function() {
    // Register routes
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'store')->name('register.store');
    Route::get('/isiEmail', 'isiemail')->name('isiemail');

    // Login routes
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'autenticate')->name('login.authenticate');
    // Route::get('/dashboard', 'dashboard')->name('dashboard');

    // Beranda route
    Route::get('/beranda', 'beranda')->name('beranda');

    // Logout route
    Route::post('/logout', 'logout')->name('logout');

    Route::group(['middleware' => ['admin']], function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/buku', [AdminController::class, 'store'])->name('buku.store');
        Route::get('/buku/create', [AdminController::class, 'create'])->name('buku.create');
        Route::delete('/buku/{id}', [AdminController::class, 'destroy'])->name('buku.destroy');
        Route::get('/buku/{id}/edit', [AdminController::class, 'edit'])->name('buku.edit');
        Route::post('/buku/{id}', [AdminController::class, 'update'])->name('buku.update');
        Route::get('/buku/search', [AdminController::class, 'search'])->name('buku.search');
    });
    Route::get('/welcome', [BukuController::class, 'index'])->name('buku.index')->middleware('auth');

});
