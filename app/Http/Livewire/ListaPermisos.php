<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ListaPermisos extends Component
{
    public $casilla_permisos='d-none';
    public $nombre_permiso;
    public $listeners = ['mostrar'];
    public $rol;
    public $permisos_rol = []; //aqui se guardan los permisos de acuerdo al rol seleccionado

    public function mostrar($rol_id)
    {
        $this->permisos_rol = [];
        $this->casilla_permisos = '';
        $this->rol = Role::find($rol_id);
        
        if($this->rol != NULL)
        {
            for ($i=0; $i < sizeof($this->rol['permissions']); $i++)
            { 
                $this->permisos_rol[$i] = $this->rol['permissions'][$i]->name;
            }
        }

        //si se selecciona donde no hay rol, esconde los permisos
        if($this->rol == NULL) $this->casilla_permisos='d-none';
    }

    public function asigna_permiso($bandera, $permiso_id)
    {
        $permiso = Permission::find($permiso_id);
        //con bandera verifico si esta chequeado, para revocar o darle el permiso
        if($bandera == 'checked')
        {
            $this->rol->revokePermissionTo($permiso);
            $this->emit('message', 'Revocado');
        }
        else
        {
            
            $this->rol->givePermissionTo($permiso);
            $this->emit('message', 'Asignado');
        }
    }

    public function render()
    {
        if($this->rol != NULL) $this->mostrar($this->rol->id);
        $roles = Role::all();
        $permisos = Permission::all();
        return view('livewire.lista-permisos', compact('roles', 'permisos'));
    }
}
