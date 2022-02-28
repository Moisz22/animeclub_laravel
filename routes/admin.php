<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GenderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ParametroController;
use App\Http\Controllers\Admin\PermisoController;
use App\Http\Controllers\RolController;

Route::get('', [HomeController::class, 'index']);
Route::get('generos', [GenderController::class, 'index'])->name('generos.index')->middleware('can:generos');
Route::get('usuarios/consultar', [UserController::class, 'consultar'])->name('usuarios.consultar');
Route::post('usuarios/update/{id}', [UserController::class, 'update'])->name('usuarios.update');
Route::post('usuarios/eliminar_mas', [UserController::class, 'eliminarmas'])->name('usuarios.eliminarmas');
Route::resource('usuarios', UserController::class)->names('usuarios')->middleware('can:usuarios')->except(['update']);
Route::get('roles/consultar', [RolController::class, 'consultar'])->name('roles.consultar')->middleware('can:roles');
Route::get('roles/consultadata', [RolController::class, 'consultadata'])->name('roles.consultadata')->middleware('can:roles');
Route::post('roles/update/{id}', [RolController::class, 'update'])->name('roles.update');
Route::post('roles/eliminar_mas', [RolController::class, 'eliminarmas'])->name('roles.eliminarmas');
Route::resource('roles', RolController::class)->names('roles')->middleware('can:roles')->except(['update']);
Route::resource('permisos', PermisoController::class)->names('permisos')->middleware('can:permisos');
Route::get('parametros', [ParametroController::class, 'index'])->name('parametros.index')->middleware('can:parametros');

