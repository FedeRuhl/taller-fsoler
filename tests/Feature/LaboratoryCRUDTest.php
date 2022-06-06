<?php

namespace Tests\Feature;

use App\Models\Laboratory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaboratoryCRUDTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_laboratories_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = 10;

        Laboratory::factory()->count($expectedCount)->create();

        $response = $this->getJson('api/laboratories');

        $response->assertStatus(200);

        $laboratories = $response->original['data'];

        $this->assertCount($expectedCount, $laboratories);
    }

    public function test_a_service_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->assertDatabaseCount('laboratories', 0);

        $expectedAttributes = [
            'name' => 'Laboratorio N° 1'
        ];

        $response = $this->postJson('api/laboratories', $expectedAttributes);

        $response->assertStatus(200);

        $this->assertDatabaseCount('laboratories', 1);

        $this->assertDatabaseHas('laboratories', $expectedAttributes);
    }

    public function test_a_service_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedLaboratory = Laboratory::create([
            'name' => 'Laboratorio N° 1'
        ]);

        $response = $this->getJson('api/laboratories/' . $expectedLaboratory->id);

        $response->assertStatus(200);

        $service = $response->original['data'];

        $this->assertEquals($expectedLaboratory->getAttributes(), $service->getAttributes());
    }

    public function test_a_service_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $service = Laboratory::create([
            'name' => 'Laboratorio N° 1'
        ]);

        $response = $this->putJson('api/laboratories/' . $service->id, [
            'name' => 'Laboratorio N° 1 actualizado!'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('laboratories', [
            'id' => $service->id,
            'name' => 'Laboratorio N° 1 actualizado!'
        ]);
    }

    public function test_a_service_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $service = Laboratory::create([
            'name' => 'Laboratorio N° 1'
        ]);

        $response = $this->deleteJson('api/laboratories/' . $service->id);

        $response->assertStatus(200);

        $this->assertDeleted($service);
    }
}