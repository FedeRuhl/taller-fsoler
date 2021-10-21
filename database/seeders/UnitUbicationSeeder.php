<?php

namespace Database\Seeders;

use App\Models\UnitUbication;
use Illuminate\Database\Seeder;

class UnitUbicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnitUbication::factory()->count(10)->create();
    }
}
