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
        $mantenimiento = $this->mantenimiento = Maintenance::find(1);

        if($mantenimiento->mantenimiento == 'off')
        {
            $faker = Faker\Factory::create();
            $this->token = (string)$faker->randomNumber(7, true);

            Artisan::call('down',[
                '--secret' => $this->token
            ]);

            $mantenimiento->mantenimiento = 'on';

        }
        else
        {
            $this->token = '';
            Artisan::call('up');
            $mantenimiento->mantenimiento = 'off';
        }
        
        $mantenimiento->save();
    }

    public function render()
    {
        $this->mantenimiento = Maintenance::find(1);
        return view('livewire.parametros');
    }
}
