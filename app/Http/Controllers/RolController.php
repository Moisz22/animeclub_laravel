<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function consultar()
    {
        $roles = Role::all();
        $jsonfinal = [];
        $array_temp = [];
        $rol_temp = '';
        foreach ($roles as $rol)
        {
            $array_temp = ['<input type="checkbox" value="'.$rol->id.'">','<button class="btn btn-warning" data-toggle="modal" data-target="#modalRoles" onclick="mostrar('.$rol->id.');"><i class="fa fa-pencil"></i></button> <button onclick="eliminar('."'$rol->name'".');" class="btn btn-danger"><i class="fa fa-trash"></i></button>',$rol->name]; 
            array_push($jsonfinal, $array_temp);
            
        }
        return response()->json(['data' => $jsonfinal]);
    }

    public function consultadata()
    {
        $roles = Role::all();
        $jsonfinal = [];
        $array_temp = [];
        $rol_temp = '';
        foreach ($roles as $rol)
        {
            $array_temp = [$rol->id,$rol->name]; 
            array_push($jsonfinal, $array_temp);
            
        }
        return response()->json(['data' => $jsonfinal]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validar = Validator::make(
            $request->all(),
            [
                'nombre' => 'bail|required|min:1|unique:roles,name'
            ]
        );

        if($validar->fails())
        {
            return response()->json(['sms' => $validar->errors()->all()]);
        }

        Role::create(['name' => $request->nombre]);

        return response()->json(['sms' => 'ok']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rol = Role::find($id);
        return response()->json(['data' => $rol]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rol = Role::find($id);
        $rol->name = $request->nombre;
        $rol->save();
        return response()->json(['sms' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nombre)
    {
        $roles_usados = User::role($nombre)->first();

        if($roles_usados == '')
        {
            Role::findByName($nombre)->delete();
            return response()->json(['sms' => 'ok']);
        }
        else
        {
            return response()->json(['sms' => 'El rol está siendo usado']);
        }
    }

    public function eliminarmas(Request $request)
    {
        $ids = json_decode($request->ids);
        $roles_sin_eliminar = [];
        $todos_eliminados = true;
        DB::beginTransaction();
        try
        {
            foreach ($ids as $id)
            {
                $rol = Role::findById($id);
                if(User::role($rol->name)->first() == "")
                {
                    DB::table('roles')->where('id', $rol->id)->delete();
                }
                else
                {
                    array_push($roles_sin_eliminar, $rol->name);
                    $todos_eliminados = false;
                }
            }
            DB::commit();

            if($todos_eliminados)
            {
                return response()->json(['sms' => 'ok']);
            }
            else
            {
                return response()->json(['sms' => 'Roles no eliminados debido a que estan siendo usados: '.json_encode($roles_sin_eliminar)]);
            }
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json(['sms' => $e]);
        }
    }
}
