<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\UnitUbication;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitUbicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UnitUbication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $city = City::inRandomOrder()->first();

        return [
            'city_id' => $city->id,
            'province_id' => $city->province_id,
            'zip_code' => $this->faker->postcode()
        ];
    }
}
