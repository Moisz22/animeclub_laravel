<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserAdminSeeder;
use App\Models\Gender;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Gender::factory(20)->create();
        $this->call(UserAdminSeeder::class);
    }
}
