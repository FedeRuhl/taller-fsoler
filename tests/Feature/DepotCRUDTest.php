<?php

namespace Tests\Feature;

use App\Models\Depot;
use App\Models\DepotProduct;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\TestCaseWithSeed;

class DepotCRUDTest extends TestCaseWithSeed
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_depots_can_be_indexed()
    {
        $this->withoutExceptionHandling();
        $expectedCount = Depot::count();

        $response = $this->getJson('api/depots');

        $response->assertStatus(200);

        $depots = $response->original['data'];

        $this->assertCount($expectedCount, $depots);
    }

    public function test_a_depot_can_be_created()
    {
        $this->withoutExceptionHandling();
        $depotCount = Depot::count();

        $response = $this->postJson('api/depots', [
            'name' => 'Depósito N° 1'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseCount('depots', $depotCount + 1);

        $this->assertDatabaseHas('depots', [
            'name' => 'Depósito N° 1'
        ]);
    }

    public function test_a_depot_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedDepot = Depot::inRandomOrder()->first();

        $response = $this->getJson('api/depots/' . $expectedDepot->id);

        $response->assertStatus(200);

        $depot = $response->original['data'];

        $this->assertEquals($expectedDepot->getAttributes(), $depot->getAttributes());
    }

    public function test_a_depot_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $depot = Depot::inRandomOrder()->first();

        $response = $this->putJson('api/depots/' . $depot->id, [
            'name' => 'Depósito actualizado!'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('depots', [
            'id' => $depot->id,
            'name' => 'Depósito actualizado!'
        ]);
    }

    public function test_a_depot_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $depot = Depot::inRandomOrder()->first();

        $response = $this->deleteJson('api/depots/' . $depot->id);

        $response->assertStatus(200);

        $this->assertDeleted($depot);
    }

    public function test_a_depot_product_can_be_modified()
    {
        $depotProductCount = DepotProduct::count();
        $depotId = Depot::inRandomOrder()->value('id');
        $productId = Product::inRandomOrder()->value('id');

        $expectedAttributes = [
            'stock' => random_int(1, 50),
            'expiration_date' => '2023-01-01',
            'lote_code' => 'ABC123'
        ];

        $response = $this->postJson("api/depots/{$depotId}/products/{$productId}", $expectedAttributes);
        $response->assertStatus(200);

        $expectedAttributes['depot_id'] = $depotId;
        $expectedAttributes['product_id'] = $productId;

        $this->assertDatabaseCount('depot_product', $depotProductCount + 1);
        $this->assertDatabaseHas('depot_product', $expectedAttributes);
    }
}