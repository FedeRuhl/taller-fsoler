<?php

namespace Database\Factories;

use App\Models\Unit;
use App\Models\UnitUbication;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $unitUbication = UnitUbication::factory()->create();
        
        return [
            'unit_ubication_id' => $unitUbication->id,
            'name' => $this->faker->word()
        ];
    }
}