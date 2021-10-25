<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepotCRUDTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_depot_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->assertDatabaseCount('depots', 0);

        $response = $this->post('api/depots', [
            'name' => 'Depósito N° 1'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseCount('depots', 1);

        $this->assertDatabaseHas('depots', [
            'name' => 'Depósito N° 1'
        ]);
    }
}