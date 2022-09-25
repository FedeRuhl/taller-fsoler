<?php

namespace Tests\Feature;

use App\Models\Generic;
use App\Models\Laboratory;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCaseWithSeed;

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
        $genericId = Generic::value('id');
        $laboratoryId = Laboratory::value('id');

        $expectedAttributes = [
            'generic_id' => $genericId,
            'laboratory_id' => $laboratoryId,
        ];
        
        $response = $this->postJson('api/products', $expectedAttributes);
        $response->assertStatus(200);
        
        $this->assertDatabaseCount('products', $productsCount + 1);
        $this->assertDatabaseHas('products', $expectedAttributes);
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
        $laboratoryId = Laboratory::value('id');

        $response = $this->putJson('api/products/' . $product->id, [
            'laboratory_id' => $laboratoryId
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'laboratory_id' => $laboratoryId
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