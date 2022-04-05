<?php

namespace Database\Factories;

use App\Models\Hospitalization;
use App\Models\HospitalizationHistory;
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
            'is_ambulatory' => $this->faker->boolean()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Hospitalization $hospitalization) {
            $hospitalization->histories()->create([
                'service_id' => $this->faker->numberBetween(1, 2),
                'start_date' => $this->faker->dateTimeBetween('-1 years', 'now')
            ]);
        });
    }
}
