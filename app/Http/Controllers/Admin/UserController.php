<?php

namespace App\Http\Controllers\admin;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Maintenance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
            $array_temp = ['<input type="checkbox" value="'.$usuario->id.'">','<button class="btn btn-warning" data-toggle="modal" data-target="#modalUsuarios" onclick="mostrar('.$usuario->id.');"><i class="fa fa-pencil"></i></button> <button onclick="eliminar('.$usuario->id.');" class="btn btn-danger"><i class="fa fa-trash"></i></button>',$usuario->name, $usuario->email, $rol_temp]; 
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
                'nombre' => 'bail|required|min:3|max:255',
                'email'  => 'bail|email|required|min:3|unique:users,email|max:255',
                'rol'    => 'bail|required'
            ]
        );

        if($validar->fails())
        {
            return response()->json(['sms' => $validar->errors()->all()]);
        }

        $usuario = User::create([
            'name'  => $request->nombre,
            'email' => $request->email,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'profile_photo_path' => 'default.png'
        ]);

        $buscaRol = Role::find($request->rol);
        $usuario->assignRole($buscaRol);

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
        $usuario = User::find($id);
        $rol_id = Role::findByName($usuario->getRoleNames()[0])->id;
        $usuario->rol_id = $rol_id;
        return response()->json(['sms' => 'ok', 'data' => $usuario]);
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
        $validar = Validator::make(
            $request->all(),
            [
                'nombre' => 'bail|required|min:3|max:255',
                'email'  => 'bail|email|required|min:3|max:255',
                'rol'    => 'bail|required'
            ]
        );

        if($validar->fails())
        {
            return response()->json(['sms' => $validar->errors()->all()]);
        }

        $usuario = User::find($id);
        $usuario->name = $request->nombre;
        $usuario->email = $request->email;
        $usuario->save();

        $buscaRol = Role::find($request->rol);
        $usuario->syncRoles([$buscaRol]);
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

    public function eliminarmas(Request $request)
    {
        $ids = json_decode($request->ids);
        DB::beginTransaction();
        try
        {
            foreach ($ids as $id)
            {
                DB::table('users')->where('id', $id)->delete();
            }

            $accion = 'El usuario: '.Auth::user()->name.' eliminó a '. count($ids) .' usuarios';
            DB::table('audit')->insert([
                'user_id' => Auth::id(),
                'tabla' => 'usuarios',
                'accion' => $accion,
                'metodo' => 'eliminarmas',
                'visto' => false,
                'created_at' => Carbon::now()
            ]);

            DB::commit();
            return response()->json(['sms' => 'ok']);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json(['sms' => $e]);
        }
    }
}
