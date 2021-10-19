<?php

namespace Database\Seeders;

use App\Models\Generic;
use Illuminate\Database\Seeder;

class GenericSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Generic::factory()->count(50)->create();
    }
}
