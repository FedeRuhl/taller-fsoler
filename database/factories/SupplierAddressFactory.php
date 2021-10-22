<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\SupplierAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupplierAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'zip_code' => $this->faker->postcode(),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->randomNumber(6)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (SupplierAddress $address) {
            Supplier::create([
                'supplier_address_id' => $address->id,
                'CUIT' => $this->faker->randomNumber(8, true),
                'company_name' => $this->faker->word()
            ]);
        });
    }
}
