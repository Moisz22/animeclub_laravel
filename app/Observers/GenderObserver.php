<?php

namespace App\Observers;

use App\Models\Gender;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GenderObserver
{
    /**
     * Handle the Gender "created" event.
     *
     * @param  \App\Models\Gender  $gender
     * @return void
     */
    public function created(Gender $gender)
    {
        $accion = 'El usuario: '.Auth::user()->name.' creó al genero: '.$gender->name;
        DB::table('audit')->insert([
            'user_id' => Auth::id(),
            'tabla' => 'genero',
            'accion' => $accion,
            'metodo' => 'create',
            'visto' => false,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Handle the Gender "updated" event.
     *
     * @param  \App\Models\Gender  $gender
     * @return void
     */
    public function updated(Gender $gender)
    {
        $accion = 'El usuario: '.Auth::user()->name.' actualizó al genero: '.$gender->name;
        DB::table('audit')->insert([
            'user_id' => Auth::id(),
            'tabla' => 'genero',
            'accion' => $accion,
            'metodo' => 'update',
            'visto' => false,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Handle the Gender "deleted" event.
     *
     * @param  \App\Models\Gender  $gender
     * @return void
     */
    public function deleted(Gender $gender)
    {
        $accion = 'El usuario: '.Auth::user()->name.' eliminó al genero: '.$gender->name;
        DB::table('audit')->insert([
            'user_id' => Auth::id(),
            'tabla' => 'genero',
            'accion' => $accion,
            'metodo' => 'delete',
            'visto' => false,
            'created_at' => Carbon::now()
        ]);
    }

}
