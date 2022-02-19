<?php

namespace App\Http\Controllers\admin;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Maintenance;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginacion = Maintenance::select('valor')->where('nombre', 'paginacion')->get()[0]->valor;
        $roles = $this->roles = Role::all();
        $usuarios = User::all();
        return view('admin.usuarios.index', compact('paginacion', 'roles', 'usuarios'));
    }

    public function consultar()
    {
        $usuarios = User::all();

        $jsonfinal = [];
        $array_temp = [];
        $rol_temp = '';
        foreach ($usuarios as $usuario)
        {
            foreach($usuario->getRoleNames() as $name)
            {
                $rol_temp = $name;
            }
            $array_temp = ['<input type="checkbox">', $usuario->name, $usuario->email, $rol_temp, '<button class="btn btn-success" onclick="editar();"><i class="fa fa-pencil"></i></button> <button onclick="eliminar('.$usuario->id.');" class="btn btn-danger"><i class="fa fa-trash"></i></button>']; 
            array_push($jsonfinal, $array_temp);
            
        }
        return response()->json(['data' => $jsonfinal]);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            User::destroy($id);
            return response()->json(['sms' => 'ok']);
        }
        catch(Exception $e)
        {
            return response()->json(['sms' => $e]);
        }
        
    }
}
