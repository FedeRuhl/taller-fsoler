<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'dni' => $this->faker->randomNumber(8),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Person $person) {
            Phone::create([
                'person_id' => $person->id,
                'number' => $this->faker->phoneNumber()
            ]);
        });
    }
}
