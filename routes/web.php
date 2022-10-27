<?php

use App\Http\Controllers\AnimeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\Prueba;


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

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/',[AnimeController::class, 'index']); /* ->middleware(['auth:sanctum', 'verified']) */;

/* Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard'); */

Route::resource('animes', AnimeController::class)->only('index');

/* Route::get('correo', function(){
    Mail::to('payasohackero96@gmail.com')->send(new Prueba);
}); */
