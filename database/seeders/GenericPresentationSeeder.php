<?php

namespace Database\Seeders;

use App\Models\GenericPresentation;
use Illuminate\Database\Seeder;

class GenericPresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GenericPresentation::factory()->count(5)->create();
    }
}
