<?php

namespace Tests\Feature;

use App\Models\Depot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepotCRUDTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_depots_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = 10;

        Depot::factory()->count($expectedCount)->create();

        $response = $this->getJson('api/depots');

        $response->assertStatus(200);

        $depots = $response->original['data'];

        $this->assertCount($expectedCount, $depots);
    }

    public function test_a_depot_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->assertDatabaseCount('depots', 0);

        $response = $this->postJson('api/depots', [
            'name' => 'Depósito N° 1'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseCount('depots', 1);

        $this->assertDatabaseHas('depots', [
            'name' => 'Depósito N° 1'
        ]);
    }

    public function test_a_depot_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedDepot = Depot::create([
            'name' => 'Depósito N° 1'
        ]);

        $response = $this->getJson('api/depots/' . $expectedDepot->id);

        $response->assertStatus(200);

        $depot = $response->original['data'];

        $this->assertEquals($expectedDepot->getAttributes(), $depot->getAttributes());
    }

    public function test_a_depot_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $depot = Depot::create([
            'name' => 'Depósito N° 1'
        ]);

        $response = $this->putJson('api/depots/' . $depot->id, [
            'name' => 'Depósito N° 1 actualizado!'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('depots', [
            'id' => $depot->id,
            'name' => 'Depósito N° 1 actualizado!'
        ]);
    }

    public function test_a_depot_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $depot = Depot::create([
            'name' => 'Depósito N° 1'
        ]);

        $response = $this->deleteJson('api/depots/' . $depot->id);

        $response->assertStatus(200);

        $this->assertDeleted($depot);
    }
}