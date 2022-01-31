<?php

namespace Database\Seeders;

use App\Models\Maintenance;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol = Role::create(['name' => 'administrador']);
        $permiso = Permission::create(['name' => 'usuarios']);
        $rol->givePermissionTo($permiso);
        $permiso = Permission::create(['name' => 'roles']);
        $rol->givePermissionTo($permiso);
        $permiso = Permission::create(['name' => 'permisos']);
        $rol->givePermissionTo($permiso);
        $permiso = Permission::create(['name' => 'animes']);
        $rol->givePermissionTo($permiso);
        $permiso = Permission::create(['name' => 'ovas']);
        $rol->givePermissionTo($permiso);
        $permiso = Permission::create(['name' => 'peliculas']);
        $rol->givePermissionTo($permiso);
        $permiso = Permission::create(['name' => 'mangas']);
        $rol->givePermissionTo($permiso);
        $permiso = Permission::create(['name' => 'novelas_ligeras']);
        $rol->givePermissionTo($permiso);
        $permiso = Permission::create(['name' => 'generos']);
        $rol->givePermissionTo($permiso);
        $permiso = Permission::create(['name' => 'resenas']);
        $rol->givePermissionTo($permiso);
        $permiso = Permission::create(['name' => 'parametros']);
        $rol->givePermissionTo($permiso);
        $permiso = Permission::create(['name' => 'progreso']);
        $rol->givePermissionTo($permiso);
        

        $user = new User;
        $user->name = 'Moises Suarez';
        $user->email = 'moises@gmail.com';
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        $user->profile_photo_path = 'https://i.pinimg.com/originals/85/1d/19/851d19e760123bf7c1d7c82bb7c93ca3.png';
        $user->save();

        $user->assignRole($rol);

        Maintenance::create([
            'nombre' => 'mantenimiento',
            'valor'  => 'off'
        ]);

        Maintenance::create([
            'nombre' => 'paginacion',
            'valor'  => '5'
        ]);
    }
}
