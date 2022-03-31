<?php

namespace Tests\Feature;

use App\Models\GenericPresentation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenericPresentationCRUDTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_generic_presentations_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = 10;
        
        GenericPresentation::factory()->count($expectedCount)->create();

        $response = $this->getJson('api/generic-presentations');

        $response->assertStatus(200);

        $generics = $response->original['data'];

        $this->assertCount($expectedCount, $generics);
    }

    public function test_a_generic_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->assertDatabaseCount('generic_presentations', 0);

        $expectedAttributes = [
            'name' => '50 ml'
        ];

        $response = $this->postJson('api/generic-presentations', $expectedAttributes);

        $response->assertStatus(200);

        $this->assertDatabaseCount('generic_presentations', 1);

        $this->assertDatabaseHas('generic_presentations', $expectedAttributes);
    }

    public function test_a_generic_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedGenericPresentation = GenericPresentation::create([
            'name' => '25 ml',
        ]);

        $response = $this->getJson('api/generic-presentations/' . $expectedGenericPresentation->id);

        $response->assertStatus(200);

        $generic = $response->original['data'];

        $this->assertEquals($expectedGenericPresentation->getAttributes(), $generic->getAttributes());
    }

    public function test_a_generic_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $expectedGenericPresentation = GenericPresentation::create([
            'name' => '25 ml',
        ]);

        $response = $this->putJson('api/generic-presentations/' . $expectedGenericPresentation->id, [
            'name' => '100 ml vidrio'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('generic_presentations', [
            'id' => $expectedGenericPresentation->id,
            'name' => '100 ml vidrio'
        ]);
    }

    public function test_a_generic_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $genericPresentation = GenericPresentation::create([
            'name' => '25 ml',
        ]);

        $response = $this->deleteJson('api/generic-presentations/' . $genericPresentation->id);

        $response->assertStatus(200);

        $this->assertDeleted($genericPresentation);
    }
}