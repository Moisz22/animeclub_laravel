<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $accion = 'El usuario: '.Auth::user()->name.' creó al usuario: '.$user->name;
        DB::table('audit')->insert([
            'user_id' => Auth::id(),
            'tabla' => 'usuarios',
            'accion' => $accion,
            'metodo' => 'create',
            'visto' => false,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $accion = 'El usuario: '.Auth::user()->name.' actualizó al usuario: '.$user->name;
        DB::table('audit')->insert([
            'user_id' => Auth::id(),
            'tabla' => 'usuarios',
            'accion' => $accion,
            'metodo' => 'update',
            'visto' => false,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $accion = 'El usuario: '.Auth::user()->name.' eliminó al usuario: '.$user->name;
        DB::table('audit')->insert([
            'user_id' => Auth::id(),
            'tabla' => 'usuarios',
            'accion' => $accion,
            'metodo' => 'delete',
            'visto' => false,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        $accion = 'El usuario: '.Auth::user()->name.' restauró al usuario: '.$user->name;
        DB::table('audit')->insert([
            'user_id' => Auth::id(),
            'tabla' => 'usuarios',
            'accion' => $accion,
            'metodo' => 'restore',
            'visto' => false,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        $accion = 'El usuario: '.Auth::user()->name.' eliminó físicamente al usuario: '.$user->name;
        DB::table('audit')->insert([
            'user_id' => Auth::id(),
            'tabla' => 'usuarios',
            'accion' => $accion,
            'metodo' => 'forcedelete',
            'visto' => false,
            'created_at' => Carbon::now()
        ]);
    }
}
