<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anime;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ultimos_usuarios = User::orderBy('id', 'DESC')->limit(3)->get();
        $usuarios = User::all();
        $roles = Role::all();
        $arregloRoles = []; //roles
        $arregloCantidadRoles = []; //usuarios con ese rol
        foreach($roles as $rol)
        { 
            array_push($arregloRoles, $rol->name);
            array_push($arregloCantidadRoles, sizeof(User::role($rol->name)->get()));
        }
        $cantidadUsuarios = sizeof($usuarios);
        $cantidadRoles = sizeof($roles);
        $cantidadPermisos = sizeof(Permission::all());
        return view('admin.index', compact('cantidadUsuarios', 'cantidadRoles', 'cantidadPermisos', 'roles', 'arregloRoles', 'arregloCantidadRoles', 'ultimos_usuarios'));
    }

    
}
