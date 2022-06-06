<?php

namespace Database\Factories;

use App\Models\Generic;
use App\Models\Laboratory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $genericId = Generic::inRandomOrder()->value('id');
        $laboratoryId = Laboratory::inRandomOrder()->value('id');

        While (Product::where('generic_id', $genericId)
            ->where('laboratory_id', $laboratoryId)
            ->exists()) {
                $genericId = Generic::inRandomOrder()->value('id');
                $laboratoryId = Laboratory::inRandomOrder()->value('id');
            }

        return [
            'generic_id' => $genericId,
            'laboratory_id' => $laboratoryId,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->depots()->attach($this->faker->numberBetween(1, 2), [
                'stock' => $this->faker->randomNumber(3),
                'expiration_date' => $this->faker->dateTimeBetween('+0 days', '+2 years'),
                'lote_code' => $this->faker->bothify('###???')
            ]);
        });
    }
}
