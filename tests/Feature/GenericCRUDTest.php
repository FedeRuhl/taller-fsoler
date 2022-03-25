<?php

namespace Tests\Feature;

use App\Models\Generic;
use App\Models\GenericPresentation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// TODO: generic presentations CRUD

class GenericCRUDTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_generics_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = 10;
        
        GenericPresentation::factory()->count(5)->create();
        Generic::factory()->count($expectedCount)->create();

        $response = $this->getJson('api/generics');

        $response->assertStatus(200);

        $generics = $response->original['data'];

        $this->assertCount($expectedCount, $generics);
    }

    public function test_a_generic_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->assertDatabaseCount('generics', 0);

        GenericPresentation::factory()->count(5)->create();

        $expectedAttributes = [
            'SIByS_code' => '1234',
            'name' => 'Genérico N° 1',
            'is_disposable' => 0,
            'presentation_ids' => [1, 2]
        ];

        $response = $this->postJson('api/generics', $expectedAttributes);

        unset($expectedAttributes['presentation_ids']);

        $response->assertStatus(200);

        $this->assertDatabaseCount('generics', 1);

        $this->assertDatabaseHas('generics', $expectedAttributes);
    }

    public function test_a_generic_can_be_showed()
    {
        $this->withoutExceptionHandling();

        GenericPresentation::factory()->count(5)->create();

        $expectedGeneric = Generic::create([
            'SIByS_code' => '1234',
            'name' => 'Genérico N° 1',
            'is_disposable' => 0
        ]);

        $expectedGeneric->presentations()->sync([1, 2]);

        $response = $this->getJson('api/generics/' . $expectedGeneric->id);

        unset($expectedGeneric['presentation_ids']);

        $response->assertStatus(200);

        $generic = $response->original['data'];

        $this->assertEquals($expectedGeneric->getAttributes(), $generic->getAttributes());
    }

    public function test_a_generic_can_be_updated()
    {
        $this->withoutExceptionHandling();

        GenericPresentation::factory()->count(5)->create();

        $generic = Generic::create([
            'SIByS_code' => '1234',
            'name' => 'Genérico N° 1',
            'is_disposable' => 0
        ]);

        $generic->presentations()->sync([1, 2]);

        $response = $this->putJson('api/generics/' . $generic->id, [
            'name' => 'Genérico N° 1 actualizado!'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('generics', [
            'id' => $generic->id,
            'name' => 'Genérico N° 1 actualizado!'
        ]);
    }

    public function test_a_generic_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        GenericPresentation::factory()->count(5)->create();

        $generic = Generic::create([
            'SIByS_code' => '1234',
            'name' => 'Genérico N° 1',
            'is_disposable' => 0
        ]);

        $generic->presentations()->sync([1, 2]);

        $response = $this->deleteJson('api/generics/' . $generic->id);

        $response->assertStatus(200);

        $this->assertDeleted($generic);
    }
}