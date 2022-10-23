<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GenderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ParametroController;
use App\Http\Controllers\Admin\PermisoController;
use App\Http\Controllers\RolController;

Route::get('', [HomeController::class, 'index']);
Route::get('generos/consultadata', [GenderController::class, 'consultadata'])->name('generos.consultadata')->middleware('can:generos');
Route::get('generos/consultar', [GenderController::class, 'consultar'])->name('generos.consultar')->middleware('can:generos');
Route::post('generos/eliminar_mas', [GenderController::class, 'eliminarmas'])->name('generos.eliminarmas')->middleware('can:generos');
Route::resource('generos', GenderController::class)->names('generos')->middleware('can:generos')->except(['update', 'create']);
Route::post('generos/update/{id}', [GenderController::class, 'update'])->name('generos.update')->middleware('can:generos');
Route::get('usuarios/consultar', [UserController::class, 'consultar'])->name('usuarios.consultar')->middleware('can:usuarios');
Route::post('usuarios/update/{id}', [UserController::class, 'update'])->name('usuarios.update')->middleware('can:usuarios');
Route::post('usuarios/eliminar_mas', [UserController::class, 'eliminarmas'])->name('usuarios.eliminarmas')->middleware('can:usuarios');
Route::resource('usuarios', UserController::class)->names('usuarios')->middleware('can:usuarios')->except(['update', 'create', 'edit']);
Route::get('roles/consultar', [RolController::class, 'consultar'])->name('roles.consultar')->middleware('can:roles');
Route::get('roles/consultadata', [RolController::class, 'consultadata'])->name('roles.consultadata')->middleware('can:roles');
Route::post('roles/update/{id}', [RolController::class, 'update'])->name('roles.update')->middleware('can:roles');
Route::post('roles/eliminar_mas', [RolController::class, 'eliminarmas'])->name('roles.eliminarmas')->middleware('can:roles');
Route::resource('roles', RolController::class)->names('roles')->middleware('can:roles')->except(['update', 'create']);
Route::post('permisos/update', [PermisoController::class, 'update'])->name('permisos.update')->middleware('can:permisos');
Route::resource('permisos', PermisoController::class)->names('permisos')->middleware('can:permisos')->except(['update', 'create']);
Route::get('parametros', [ParametroController::class, 'index'])->name('parametros.index')->middleware('can:parametros');

Route::get('notifications/get',[App\Http\Controllers\NotificationController::class, 'getNotificationsData'])->name('notifications.get');
Route::get('notifications/show',[App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
Route::get('notifications/marcar_todas',[App\Http\Controllers\NotificationController::class, 'marcar_todas'])->name('notifications.marcartodas');
Route::get('notifications/consultadata', [App\Http\Controllers\NotificationController::class, 'consultadata'])->name('notifications.consultadata');