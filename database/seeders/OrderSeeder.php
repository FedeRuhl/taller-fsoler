<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderType;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderType::factory()->count(4)->create();
        Order::factory()->count(100)->create();
    }
}
