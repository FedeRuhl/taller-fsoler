<?php

namespace Tests\Feature;

use App\Models\Unit;
use App\Models\UnitUbication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnitCRUDTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_units_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = 10;

        Unit::factory()->count($expectedCount)->create();

        $response = $this->getJson('api/units');

        $response->assertStatus(200);

        $units = $response->original['data'];

        $this->assertCount($expectedCount, $units);
    }

    public function test_a_unit_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->assertDatabaseCount('units', 0);

        $ubicationExpectedAttributes = [
            'city' => 'Paraná',
            'province' => 'Entre Ríos',
            'zip_code' => '3100'
        ];

        $unitExpectedAttributes = [
            'name' => 'Unidad de prueba'
        ];

        $parameters = array_merge($ubicationExpectedAttributes, $unitExpectedAttributes);

        $response = $this->postJson('api/units', $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseCount('unit_ubications', 1);
        $this->assertDatabaseHas('unit_ubications', $ubicationExpectedAttributes);

        $this->assertDatabaseCount('units', 1);
        $this->assertDatabaseHas('units', $unitExpectedAttributes);
    }

    public function test_a_unit_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedUnit = Unit::factory()->create();

        $response = $this->getJson('api/units/' . $expectedUnit->id);

        $response->assertStatus(200);

        $unit = $response->original['data'];

        $this->assertEquals($expectedUnit->getAttributes(), $unit->getAttributes());
    }

    public function test_a_unit_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $unit = Unit::factory()->create();
        $ubicationId = $unit->ubication()->value('id');

        $response = $this->putJson('api/units/' . $unit->id, [
            'name' => 'Unidad actualizada!',
            'city' => 'Santa Fé'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('units', [
            'id' => $unit->id,
            'name' => 'Unidad actualizada!'
        ]);

        $this->assertDatabaseHas('unit_ubications', [
            'id' => $ubicationId,
            'city' => 'Santa Fé'
        ]);
    }

    public function test_a_unit_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $unit = Unit::factory()->create();

        $response = $this->deleteJson('api/units/' . $unit->id);

        $response->assertStatus(200);

        $this->assertDeleted($unit);
    }
}