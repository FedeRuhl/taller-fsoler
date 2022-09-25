<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Patient;
use App\Models\PatientAddress;
use App\Models\Person;
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
        $city = City::inRandomOrder()->first();
        $patientAddress = PatientAddress::create([
            'province_id' => $city->province_id,
            'city_id' => $city->id,
            'street' => $this->faker->streetName(),
            'number' => $this->faker->randomNumber(4)
        ]);

        return [
            'person_id' => $person->id,
            'unit_id' => $unit->id,
            'phone' => $this->faker->phoneNumber(),
            'patient_address_id' => $patientAddress->id,
            'os_number' => $this->faker->randomNumber(6, true),
            'is_military' => $this->faker->boolean(20)
        ];
    }
}
