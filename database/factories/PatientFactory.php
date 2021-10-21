<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'person_id' => $this->faker->unique()->numberBetween(11, 30),
            // 'unit_id' => $this->faker->numberBetween(1, 5),
            'unit_id' => 1,
            'os_number' => $this->faker->randomNumber(6, true),
            // 'status' => '',
            'is_military' => $this->faker->boolean(20)
        ];
    }
}
