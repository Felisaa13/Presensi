<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PresensiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KehadiranController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TabelRekapController;
use App\Http\Controllers\IzinController;




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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'doLogin'])->name('doLogin');
// Route::post('/logout', [LoginController::class, 'doLogout'])->name('doLogout');

Auth::routes();

Route::get('/siswa', function () {
    return view('layouts.users');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');
Route::post('/presensi/checkin', [PresensiController::class, 'checkIn'])->name('checkIn');
Route::post('/presensi/checkout', [PresensiController::class, 'checkOut'])->name('checkOut');
Route::get('/rekap', [TabelRekapController::class, 'index'])->name('rekap');
Route::get('/izin', [IzinController::class, 'index'])->name('izin'); // Menampilkan halaman izin

 

