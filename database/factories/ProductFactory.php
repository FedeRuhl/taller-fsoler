<?php

namespace Database\Factories;

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
        return [
            'generic_id' => $this->faker->numberBetween(1, 50),
            'lab' => $this->faker->company(),
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
