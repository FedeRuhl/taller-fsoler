<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'owner_id' => $this->faker->numberBetween(1, 10),
            'supplier_id' => $this->faker->numberBetween(1, 10),
            'order_type_id' => $this->faker->numberBetween(1, 4),
            'number' => $this->faker->phoneNumber(),
            'date' => $this->faker->dateTimeBetween('now', '+1 years')
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $order->products()->attach(
                $this->faker->numberBetween(1, 100),
                [
                    'product_quantity' => $this->faker->randomNumber(3)
                ] 
            );
        });
    }
}
