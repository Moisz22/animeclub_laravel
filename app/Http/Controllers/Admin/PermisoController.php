<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.permisos.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permisos_rol = [];
        $jsonfinal = [];
        $rol = Role::find($id);
        $permisos = Permission::all();
        
        if($rol != NULL)
        {
            for ($i=0; $i < sizeof($rol['permissions']); $i++)
            { 
                $permisos_rol[$i] = $rol['permissions'][$i]->name;
                array_push($jsonfinal, $permisos_rol[$i]);
            }
            
            foreach ($permisos as $j=>$permiso)
            {
                $jsonfinal[$j] = (in_array($permiso->name, $permisos_rol)) ? [$permiso->name, '<input type="checkbox" checked>'] : [$permiso->name, '<input type="checkbox">'];
            }
        }
        return response()->json(['data' =>$jsonfinal]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $permisos = json_decode($request->permisos);
        $rol = Role::findById($request->rol_id);
        $rol->syncPermissions($permisos);

        return response()->json(['sms' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
