<?php

namespace Database\Factories;

use App\Models\OrderType;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word()
        ];
    }
}
