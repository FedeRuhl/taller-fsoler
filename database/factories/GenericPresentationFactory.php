<?php

namespace Database\Factories;

use App\Models\GenericPresentation;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenericPresentationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GenericPresentation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word()
        ];
    }
}
