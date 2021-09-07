<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class TablaRoles extends Component
{
    use WithPagination;
    public $rol_id;
    public $nombre;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['eliminar'];
    protected $rules = [
        'nombre' => 'required'
    ];

    public function updated()
    {
        $this->validateOnly('nombre');
    }

    public function nuevo()
    {
        $rol_id = '';
        $nombre = '';
    }

    public function guardar()
    {
        $this->validate([
            'name' => 'bail|required|unique:roles,name'
        ]);

        Role::create(['name' => $this->nombre]);
        $this->emit('message', 'Rol creado con exito');
    }

    public function mostrar(Role $rol)
    {
        $this->rol_id = $rol->id;
        $this->nombre = $rol->name;
    }

    public function actualizar()
    {   
        $rol = Role::find($this->rol_id);
        $rol->name = $this->nombre;
        $rol->save();
        $this->emit('message', 'Rol editado con exito');
    }

    public function eliminar(Role $rol)
    {   
        if($rol->id != 1)
        {
            $rol->delete();
            $this->emit('message', 'Rol eliminado con exito');
        }
    }

    public function render()
    {
        $roles = Role::paginate(5);
        return view('livewire.tablas.tabla-roles', compact('roles'));
    }
}
