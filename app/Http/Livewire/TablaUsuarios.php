<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class TablaUsuarios extends Component
{
    use WithPagination;

    public $user_id;
    public $nombre;
    public $email;
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
        $this->emit('message', 'Usuario editado con exito');
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'bail|required',
            'email' => 'bail|email|unique:users,email'
        ]);

        User::create([
            'name'  => $this->nombre,
            'email' => $this->email,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);

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
        $usuarios = User::paginate(5);
        return view('livewire.tablas.tabla-usuarios', compact('usuarios'));
    }
}
