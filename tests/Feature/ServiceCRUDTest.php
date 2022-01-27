<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceCRUDTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_services_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = 10;

        Service::factory()->count($expectedCount)->create();

        $response = $this->getJson('api/services');

        $response->assertStatus(200);

        $services = $response->original['data'];

        $this->assertCount($expectedCount, $services);
    }

    public function test_a_service_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->assertDatabaseCount('services', 0);

        $expectedAttributes = [
            'name' => 'Servicio N° 1'
        ];

        $response = $this->postJson('api/services', $expectedAttributes);

        $response->assertStatus(200);

        $this->assertDatabaseCount('services', 1);

        $this->assertDatabaseHas('services', $expectedAttributes);
    }

    public function test_a_service_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedService = Service::create([
            'name' => 'Servicio N° 1'
        ]);

        $response = $this->getJson('api/services/' . $expectedService->id);

        $response->assertStatus(200);

        $service = $response->original['data'];

        $this->assertEquals($expectedService->getAttributes(), $service->getAttributes());
    }

    public function test_a_service_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $service = Service::create([
            'name' => 'Servicio N° 1'
        ]);

        $response = $this->putJson('api/services/' . $service->id, [
            'name' => 'Servicio N° 1 actualizado!'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Servicio N° 1 actualizado!'
        ]);
    }

    public function test_a_service_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $service = Service::create([
            'name' => 'Servicio N° 1'
        ]);

        $response = $this->deleteJson('api/services/' . $service->id);

        $response->assertStatus(200);

        $this->assertDeleted($service);
    }
}