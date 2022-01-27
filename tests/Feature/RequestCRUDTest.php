<?php

namespace Tests\Feature;

use App\Models\Hospitalization;
use App\Models\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCaseWithSeed;

class RequestCRUDTest extends TestCaseWithSeed
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_requests_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = Request::count();

        $response = $this->getJson('api/requests');

        $response->assertStatus(200);

        $requests = $response->original['data'];

        $this->assertCount($expectedCount, $requests);
    }

    public function test_a_request_can_be_created()
    {
        $this->withoutExceptionHandling();

        $requestsCount = Request::count();
        $this->assertDatabaseCount('requests', $requestsCount);

        $ownerId = User::whereRelation('userClass', 'name', '=', 'Personal de sanidad')
            ->value('id');
        $hospitalizationId = Hospitalization::value('id');

        $expectedAttributes = [
            'owner_id' => $ownerId,
            'hospitalization_id' => $hospitalizationId,
            'date' => '2022/01/25',
            'is_authorized' => 0
        ];
        
        $response = $this->postJson('api/requests', $expectedAttributes);
        
        $this->assertDatabaseCount('requests', $requestsCount + 1);
        
        $this->assertDatabaseHas('requests', $expectedAttributes);
        $response->assertStatus(200);
    }

    public function test_a_request_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedRequest = Request::first();

        $response = $this->getJson('api/requests/' . $expectedRequest->id);

        $response->assertStatus(200);

        $request = $response->original['data'];

        $this->assertEquals($expectedRequest->getAttributes(), $request->getAttributes());
    }

    public function test_a_request_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $request = Request::first();
        $newDate = (Carbon::now())->toDateTimeString();

        $response = $this->putJson('api/requests/' . $request->id, [
            'date' => $newDate
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'date' => $newDate
        ]);
    }

    public function test_a_request_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $request = Request::first();

        $response = $this->deleteJson('api/requests/' . $request->id);

        $response->assertStatus(200);

        $this->assertDeleted($request);
    }
}