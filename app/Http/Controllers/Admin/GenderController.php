<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gender;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.generos.index');
    }

    public function consultar()
    {
        $generos = Gender::all();
        $jsonfinal = [];
        $array_temp = [];
        foreach ($generos as $genero)
        {
            $array_temp = ['<input type="checkbox" value="'.$genero->id.'">','<button class="btn btn-warning" data-toggle="modal" data-target="#modalGeneros" onclick="mostrar('.$genero->id.');"><i class="fa fa-pencil"></i></button> <button onclick="eliminar('."'$genero->id'".');" class="btn btn-danger"><i class="fa fa-trash"></i></button>',$genero->name]; 
            array_push($jsonfinal, $array_temp);
            
        }
        return response()->json(['data' => $jsonfinal]);
    }

    public function consultadata()
    {
        $generos = Gender::all();
        $jsonfinal = [];
        $array_temp = [];
        foreach ($generos as $genero)
        {
            $array_temp = [$genero->id,$genero->nombre]; 
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
                'nombre' => 'bail|required|min:1|max:100|unique:genders,name'
            ]
        );

        if($validar->fails())
        {
            return response()->json(['sms' => $validar->errors()->all()]);
        }

        Gender::create(['name' => $request->nombre]);

        return response()->json(['sms' => 'ok']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gender $genero)
    {
        return response()->json(['data' => $genero]);
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
                'nombre' => 'bail|required|min:1|max:100|unique:genders,name'
            ]
        );

        if($validar->fails())
        {
            return response()->json(['sms' => $validar->errors()->all()]);
        }

        $rol = Gender::find($id);
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
    public function destroy(Gender $genero)
    {
        try
        {
            $genero->delete();
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
                DB::table('genders')->where('id', $id)->delete();
            }
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
