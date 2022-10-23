<?php

namespace App\Observers;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        $accion = 'El usuario con id:'.Auth::id().' creó el rol '.$role->name;
        DB::table('audit')->insert([
            'user_id' => Auth::id(),
            'tabla' => 'role',
            'accion' => $accion,
            'visto' => false,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Handle the Role "updated" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function updated(Role $role)
    {
        $accion = 'El usuario con id:'.Auth::id().' actualizó el rol '.$role->name;
        DB::table('audit')->insert([
            'user_id' => Auth::id(),
            'tabla' => 'role',
            'accion' => $accion,
            'visto' => false,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        $accion = 'El usuario con id:'.Auth::id().' eliminó el rol '.$role->name;
        DB::table('audit')->insert([
            'user_id' => Auth::id(),
            'tabla' => 'role',
            'accion' => $accion,
            'visto' => false,
            'created_at' => Carbon::now()
        ]);
    }

}
