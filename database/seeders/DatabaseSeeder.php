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
            DepotSeeder::class,
            GenericPresentationSeeder::class,
            GenericSeeder::class,
            LaboratorySeeder::class,
            ProductSeeder::class,
            UserClassSeeder::class,
            UserSeeder::class,
            ServiceSeeder::class,
            UnitSeeder::class,
            PatientSeeder::class,
            SupplierAddressSeeder::class,
            OrderSeeder::class,
            HospitalizationSeeder::class,
            RequestSeeder::class,
            WeeklyRequestSeeder::class
        ]);
    }
}
