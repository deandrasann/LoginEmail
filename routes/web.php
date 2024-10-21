<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
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
    return view('welcome');
});

Route::get('/buku', [BukuController::class,'index'])->name('index');
Route::post('/buku', [BukuController::class,'store'])->name('buku.store');
Route::get('/buku/create', [BukuController::class,'create'])->name('buku.create');

Route::delete('/buku/{id}', [BukuController::class,'destroy'])->name('buku.destroy');
//show nama fungsi di controller
Route::get('/buku/{id}/edit', [BukuController::class,'edit'])->name('buku.edit'); //nampilin
Route::post('/buku/{id}', [BukuController::class, 'update'])->name('buku.update'); //isi

Route::get('/buku/search',[BukuController::class,'search'])->name('buku.search');



