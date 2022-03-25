<?php

namespace Database\Factories;

use App\Models\Generic;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenericFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Generic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'SIByS_code' => $this->faker->unique()->randomNumber(4, true),
            'name' => $this->faker->word(),
            'is_disposable' => $this->faker->boolean()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Generic $generic) {
            $generic->presentations()->attach(
                $this->faker->numberBetween(1, 5)
            );
        });
    }
}
