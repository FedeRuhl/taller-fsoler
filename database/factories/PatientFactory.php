<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Person;
use App\Models\Patient;
use App\Models\Unit;
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
        $person = Person::factory()->create();
        $unit = Unit::inRandomOrder()->first();

        return [
            'person_id' => $person->id,
            'unit_id' => $unit->id,
            'os_number' => $this->faker->randomNumber(6, true),
            // 'status' => '',
            'is_military' => $this->faker->boolean(20)
        ];
    }
}
