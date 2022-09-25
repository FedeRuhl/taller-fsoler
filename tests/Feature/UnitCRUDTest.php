<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Unit;
use App\Models\UnitUbication;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCaseWithSeed;

class UnitCRUDTest extends TestCaseWithSeed
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_units_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = Unit::count();

        $response = $this->getJson('api/units');

        $response->assertStatus(200);

        $units = $response->original['data'];

        $this->assertCount($expectedCount, $units);
    }

    public function test_a_unit_can_be_created()
    {
        $this->withoutExceptionHandling();

        $expectedUnitCount = Unit::count() + 1;
        $expectedUbicationCount = UnitUbication::count() + 1;

        $city = City::inRandomOrder()->first();

        $expectedUbicationAttributes = [
            'city_id' => $city->id,
            'province_id' => $city->province_id,
            'zip_code' => '3100'
        ];

        $expectedUnitAttributes = [
            'name' => 'Unidad de prueba'
        ];

        $parameters = array_merge($expectedUbicationAttributes, $expectedUnitAttributes);

        $response = $this->postJson('api/units', $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseCount('unit_ubications', $expectedUbicationCount);
        $this->assertDatabaseHas('unit_ubications', $expectedUbicationAttributes);

        $this->assertDatabaseCount('units', $expectedUnitCount);
        $this->assertDatabaseHas('units', $expectedUnitAttributes);
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

        $unit = Unit::inRandomOrder()->first();
        $ubicationId = $unit->ubication()->value('id');
        $newCityId = City::inRandomOrder()->value('id');

        $response = $this->putJson('api/units/' . $unit->id, [
            'name' => 'Unidad actualizada!',
            'city_id' => $newCityId
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('units', [
            'id' => $unit->id,
            'name' => 'Unidad actualizada!'
        ]);

        $this->assertDatabaseHas('unit_ubications', [
            'id' => $ubicationId,
            'city_id' => $newCityId
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