<?php

namespace Database\Seeders;

use App\Models\WeeklyRequest;
use Illuminate\Database\Seeder;

class WeeklyRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WeeklyRequest::factory()->count(50)->create();
    }
}
