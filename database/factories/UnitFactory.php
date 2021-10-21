<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit_ubication_id' => $this->faker->unique()->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'name' => $this->faker->word()
        ];
    }
}
