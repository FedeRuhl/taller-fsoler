<?php

namespace Database\Seeders;

use App\Models\Hospitalization;
use Illuminate\Database\Seeder;

class HospitalizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hospitalization::factory()->count(5)->create();
    }
}
