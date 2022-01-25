<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\User;
use App\Models\UserClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $person = Person::factory()->create();
        $userClass = UserClass::inRandomOrder()->first();

        return [
            'person_id' => $person->id,
            'user_class_id' => $userClass->id,
            'docket' => $this->faker->randomNumber(8, true),
            'username' => $this->faker->userName(),
            'email' => $this->faker->email(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
