<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Gender;

class TablaGeneros extends Component
{
    public $generos;
    public $genero_id;
    public $nombre;
    protected $rules = [
        'nombre' => 'required|min:4|unique:genders,nombre'
    ];
    //es necesario para eventos Livewire.emit en js
    protected $listeners = [
        'eliminar'
    ];
    
    public function updated()
    {
        $this->validateOnly('nombre');
    }

    public function mostrar(Gender $genero)
    {
        $this->nombre = $genero->nombre;
        $this->genero_id = $genero->id;
    }

    public function guardar()
    {
        $genero = Gender::updateOrCreate(
            ['id' => $this->genero_id],
            ['nombre' => $this->nombre]
        );
        $mensaje = ($this->genero_id) ? 'Genero actualizado con exito' : 'Genero guardado con exito';
        $this->emit('message', $mensaje);
        $this->nuevo();
    }

    public function confirm($id)
    {
        $this->emit('confirm', $id);
    }

    public function eliminar(Gender $genero)
    {
        $genero->delete();
        $this->emit('message', 'Genero eliminado con exito');
    }

    public function nuevo()
    {
        $this->nombre = '';
        $this->genero_id = '';
    }

    public function render()
    {
        $this->generos = Gender::all();
        return view('livewire.tabla-generos');
    }
}
