<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
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
    return view('home2');
});
Route::get('/register2', function () {
    return view('register2');
})->name('register2');
Route::get('/login2', function () {
    return view('login2');
})->name('login2');
Route::get('/profile2', function () {
    return view('profile2');
})->name('profile2');
