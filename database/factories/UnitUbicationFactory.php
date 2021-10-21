<?php

namespace Database\Factories;

use App\Models\UnitUbication;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitUbicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UnitUbication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'city' => $this->faker->city(),
            'province' => $this->faker->state(),
            'zip_code' => $this->faker->postcode()
        ];
    }
}
