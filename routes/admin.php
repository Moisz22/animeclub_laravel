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
Route::get('usuarios/consultar', [UserController::class, 'consultar'])->name('usuarios.consultar');
Route::post('usuarios/update/{id}', [UserController::class, 'update'])->name('usuarios.update');
Route::post('usuarios/eliminar_mas', [UserController::class, 'eliminarmas'])->name('usuarios.eliminarmas');
Route::resource('usuarios', UserController::class)->names('usuarios')->middleware('can:usuarios')->except(['update', 'delete']);
Route::get('roles/consultar', [RolController::class, 'consultar'])->name('roles.consultar')->middleware('can:roles');
Route::post('roles/update/{id}', [RolController::class, 'update'])->name('roles.update');
Route::post('roles/eliminar_mas', [RolController::class, 'eliminarmas'])->name('roles.eliminarmas');
Route::resource('roles', RolController::class)->names('roles')->middleware('can:roles')->except(['update']);
Route::get('permisos', [PermisoController::class, 'index'])->name('permisos.index')->middleware('can:permisos');
Route::get('parametros', [ParametroController::class, 'index'])->name('parametros.index')->middleware('can:parametros');

