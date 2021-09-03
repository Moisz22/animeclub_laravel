<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gender;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generos = Gender::all();
        return view('admin.generos.index', compact('generos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.generos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'genero_nombre' => 'required|min:4|max:100|unique:genders,nombre'
        ]);

        $genero = new Gender;
        $genero->nombre = $request->input('genero_nombre');
        $genero->save();

        return redirect()->route('generos.index')->with('message', 'Genero creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gender $genero)
    {
        return response()->array($genero)->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *p
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Gender $genero)
    {
        return view('admin.generos.edit', compact('genero'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gender $genero)
    {
        $request->validate([
            'genero_nombre' => 'required|min:4|max:100'
        ]);
        
        $generos = Gender::all();
        $genero->nombre = $request->input('genero_nombre');
        $genero->save();
        return redirect()->route('generos.index')->with('message', 'Genero actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gender $genero)
    {
        $genero->delete();
        return redirect()->route('generos.index')->with('message', 'Genero eliminado correctamente');
    }
}
