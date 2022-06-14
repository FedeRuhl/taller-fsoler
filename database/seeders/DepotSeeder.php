<?php

namespace Database\Seeders;

use App\Constants;
use App\Models\Depot;
use Illuminate\Database\Seeder;

class DepotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Depot::create([
            'name' => Constants::DEPOTS['plan_18']
        ]);

        Depot::create([
            'name' => Constants::DEPOTS['fusea']
        ]);

        // Depot::factory()->count(2)->create();
    }
}
