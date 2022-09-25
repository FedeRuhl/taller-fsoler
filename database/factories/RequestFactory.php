<?php

namespace Database\Factories;

use App\Models\Generic;
use App\Models\Product;
use App\Models\Request;
use App\Models\GenericRequestProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Request::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'owner_id' => $this->faker->numberBetween(1, 10),
            'hospitalization_id' => $this->faker->numberBetween(1, 5),
            'date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'is_authorized' => $this->faker->boolean()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Request $request) {

            $genericIds = Generic::has('products')->pluck('id');

            $totalQuantity = $this->faker->numberBetween(20, 30);

            $request->generics()->attach($this->faker->randomElement($genericIds), [
                'generics_total_quantity' => $totalQuantity,
                'generics_consumed_quantity' => 0
            ]);

            $product = Product::where('generic_id', $request->generics->first()->id)->first();

            GenericRequestProduct::create([
                'generic_request_id' => $request->generics->first()->pivot->id,
                'product_id' => $product->id,
                'depot_id' => $product->depots()->value('depots.id'),
                'products_quantity' => $totalQuantity
            ]);

        });
    }
}
