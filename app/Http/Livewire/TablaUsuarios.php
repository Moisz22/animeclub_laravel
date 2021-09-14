<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class TablaUsuarios extends Component
{
    use WithPagination;

    public $user_id;
    public $nombre;
    public $email;
    public $roles; //todos los roles
    public $rol_id;   //rol elegido en el select
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['eliminar'];
    protected $rules = [
        'nombre' => 'required',
        'email' =>  'required|email'
    ];

    public function updated()
    {
        $this->validateOnly('nombre');
        $this->validateOnly('email');
    }

    public function mostrar(User $user)
    {
        $this->user_id = $user->id;
        $this->nombre = $user->name;
        $this->email = $user->email;
    }

    public function nuevo()
    {
        $this->resetValidation();
        $this->user_id = '';
        $this->nombre = '';
        $this->email = '';
    }

    public function actualizar()
    {
        $this->validate();
        $usuario = User::find($this->user_id);
        $usuario->name = $this->nombre;
        $usuario->email = $this->email;
        $usuario->save();

        $buscaRol = Role::find($this->rol_id);
        $usuario->syncRoles([$buscaRol]);
        $this->emit('message', 'Usuario editado con exito');
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'bail|required',
            'email' => 'bail|email|unique:users,email'
        ]);

        $usuario = User::create([
            'name'  => $this->nombre,
            'email' => $this->email,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);

        $buscaRol = Role::find($this->rol_id);
        $usuario->assignRole($buscaRol);

        $this->emit('message', 'Usuario creado con exito');
        $this->nuevo();
    }

    public function eliminar(User $user)
    {
        if($user->id != 1)
        {
            $user->delete();
            $this->emit('message', 'Usuario eliminado con exito');
        }
    }

    public function render()
    {
        $this->roles = Role::all();
        $usuarios = User::paginate(5);
        return view('livewire.tablas.tabla-usuarios', compact('usuarios'));
    }
}
