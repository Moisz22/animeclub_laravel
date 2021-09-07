<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Gender;
use Livewire\WithPagination;

class TablaGeneros extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $genero_id;
    public $nombre;
    protected $rules = [
        'nombre' => 'required|unique:genders,nombre'
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
        $this->validate();

        $genero = Gender::create([
            'nombre' => $this->nombre
        ]);
        
        $this->emit('message', 'Genero guardado con exito');
        $this->nuevo();
    }

    public function actualizar()
    {
        $validar = $this->validate([
            'nombre' => 'required',
            'genero_id' => 'required'
        ]);
        
        $genero = Gender::find($this->genero_id);
        $genero->nombre = $this->nombre;
        $genero->save();
        $this->emit('message', 'Genero actualizado con exito'); 

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
        $this->resetValidation();
        $this->nombre = '';
        $this->genero_id = '';
    }

    public function render()
    {
        $generos = Gender::paginate(5);
        return view('livewire.tablas.tabla-generos', compact('generos'));
    }
}
