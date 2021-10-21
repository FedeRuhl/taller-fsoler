<?php

namespace Database\Seeders;

use App\Models\UserClass;
use Illuminate\Database\Seeder;

class UserClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserClass::factory()->count(4)->create();
    }
}
