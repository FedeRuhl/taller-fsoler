<?php

namespace Database\Seeders;

use App\Models\SupplierAddress;
use Illuminate\Database\Seeder;

class SupplierAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SupplierAddress::factory()->count(10)->create();
    }
}
