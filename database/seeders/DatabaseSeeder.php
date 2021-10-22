<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PersonSeeder::class,
            DepotSeeder::class,
            GenericSeeder::class,
            ProductSeeder::class,
            UserClassSeeder::class,
            UserSeeder::class,
            ServiceSeeder::class,
            UnitUbicationSeeder::class,
            UnitSeeder::class,
            PatientSeeder::class,
            SupplierAddressSeeder::class,
            OrderSeeder::class,
            HospitalizationSeeder::class,
            RequestSeeder::class,
        ]);
    }
}
