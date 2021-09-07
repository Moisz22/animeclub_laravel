<?php

use App\Http\Controllers\admin\GenderController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\RolController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index']);
Route::get('generos', [GenderController::class, 'index'])->middleware('can:generos');
Route::get('usuarios', [UserController::class, 'index'])->middleware('can:usuarios');
Route::get('roles', [RolController::class, 'index'])->middleware('can:roles');

