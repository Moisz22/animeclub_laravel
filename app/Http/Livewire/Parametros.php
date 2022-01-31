<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use App\Models\Maintenance;
use Faker;

class Parametros extends Component
{
    public $mantenimiento;
    public $token;

    public function mantenimiento()
    {
        $mantenimiento = $this->mantenimiento = Maintenance::where('nombre', 'mantenimiento')->first();

        if($mantenimiento->valor == 'off')
        {
            $faker = Faker\Factory::create();
            $this->token = (string)$faker->randomNumber(7, true);

            Artisan::call('down',[
                '--secret' => $this->token
            ]);

            $mantenimiento->valor = 'on';
            $mantenimiento->dato1 = $this->token;
        }
        else
        {
            $this->token = '';
            Artisan::call('up');
            $mantenimiento->valor = 'off';
            $mantenimiento->dato1 = NULL;
        }
        
        $mantenimiento->save();
    }

    public function render()
    {
        $this->mantenimiento = Maintenance::where('nombre', 'mantenimiento')->first();
        return view('livewire.parametros');
    }
}
