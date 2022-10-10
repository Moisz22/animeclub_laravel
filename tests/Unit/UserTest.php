<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class UserTest extends TestCase
{
    use WithoutMiddleware;

    public $user;
    public $email;
    public $password;

    protected function setUp(): void
    {
        $faker = Faker::create('es EC');
        $faker->seed(1234);
        $this->user = $faker->name();
        $this->email = $faker->email();
        $this->password = $faker->password();
    }

    public function test_crear_usuario()
    {
        parent::setUp();

        $this->post('admin/usuarios', [
            'nombre' => $this->user,
            'email' => $this->email,
            'rol' => 1
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $this->user,
            'email' => $this->email
        ]);
    }

    /* public function test_editar_usuario()
    {
        
    } */

    public function test_eliminar_usuario()
    {
        parent::setUp();

        $id = User::select('id')->where('email',$this->email)->first()->id;

        $this->delete('admin/usuarios/'.$id);

        User::withTrashed()->find($id)->forceDelete();

        $this->assertTrue(true);
    }
}
