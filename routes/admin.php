<?php

use App\Http\Controllers\admin\GenderController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index']);
Route::resource('generos', GenderController::class)->except(['show']);

