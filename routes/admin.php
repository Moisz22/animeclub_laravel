<?php

use App\Http\Controllers\admin\GenderController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\admin\ParametroController;
use App\Http\Controllers\admin\PermisoController;
use App\Http\Controllers\RolController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index']);
Route::get('generos', [GenderController::class, 'index'])->name('generos.index')->middleware('can:generos');
Route::get('usuarios', [UserController::class, 'index'])->name('usuarios.index')->middleware('can:usuarios');
Route::get('roles', [RolController::class, 'index'])->name('roles.index')->middleware('can:roles');
Route::get('permisos', [PermisoController::class, 'index'])->name('permisos.index')->middleware('can:permisos');
Route::get('parametros', [ParametroController::class, 'index'])->name('parametros.index')->middleware('can:parametros');

