<?php

namespace Database\Factories;

use App\Models\UserClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserClassFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserClass::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
