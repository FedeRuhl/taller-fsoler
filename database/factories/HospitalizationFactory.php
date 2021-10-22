<?php

namespace Database\Factories;

use App\Models\Hospitalization;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class HospitalizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hospitalization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $patientIds = Patient::all()->pluck('id');

        return [
            'patient_id' => $this->faker->unique()->randomElement($patientIds),
            'service_id' => $this->faker->numberBetween(1, 2),
            'is_ambulatory' => $this->faker->boolean(),
            'start_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            // 'end_date' => $this->faker->dateTimeBetween('now', '+1 years')
        ];
    }
}
