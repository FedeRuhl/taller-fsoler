<?php

namespace Tests\Feature;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Generic;
use App\Models\Product;
use Tests\TestCaseWithSeed;
use App\Models\Hospitalization;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductCRUDTest extends TestCaseWithSeed
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_products_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = Product::count();

        $response = $this->getJson('api/products');

        $response->assertStatus(200);

        $products = $response->original['data'];

        $this->assertCount($expectedCount, $products);
    }

    public function test_a_product_can_be_created()
    {
        $this->withoutExceptionHandling();

        $productsCount = Product::count();
        $this->assertDatabaseCount('products', $productsCount);

        $genericId = Generic::value('id');

        $expectedAttributes = [
            'generic_id' => $genericId,
            'lab' => 'Test lab',
        ];
        
        $response = $this->postJson('api/products', $expectedAttributes);
        
        $this->assertDatabaseCount('products', $productsCount + 1);
        
        $this->assertDatabaseHas('products', $expectedAttributes);
        $response->assertStatus(200);
    }

    public function test_a_product_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedProduct = Product::first();

        $response = $this->getJson('api/products/' . $expectedProduct->id);

        $response->assertStatus(200);

        $product = $response->original['data'];

        $this->assertEquals($expectedProduct->getAttributes(), $product->getAttributes());
    }

    public function test_a_product_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $product = Product::first();

        $response = $this->putJson('api/products/' . $product->id, [
            'lab' => 'New lab'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'lab' => 'New lab'
        ]);
    }

    public function test_a_product_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $product = Product::first();

        $response = $this->deleteJson('api/products/' . $product->id);

        $response->assertStatus(200);

        $this->assertDeleted($product);
    }
}