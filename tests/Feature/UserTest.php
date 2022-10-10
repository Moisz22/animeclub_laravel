<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use WithoutMiddleware;

    public function test_existe_ruta_usuarios_index()
    {
        $response = $this->get('admin/usuarios');
        $response->assertStatus(200);
    }

    public function test_existe_ruta_usuarios_crear()
    {
        $response = $this->post('admin/usuarios');
        $response->assertStatus(200);
    }
}
