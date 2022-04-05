<?php

namespace Tests\Feature;

use App\Models\Hospitalization;
use App\Models\Service;
use App\Models\WeeklyRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCaseWithSeed;

class WeeklyRequestCRUDTest extends TestCaseWithSeed
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

        $expectedCount = WeeklyRequest::count();

        $response = $this->getJson('api/weekly-requests');

        $response->assertStatus(200);

        $requests = $response->original['data'];

        $this->assertCount($expectedCount, $requests);
    }

    public function test_a_request_can_be_created()
    {
        $this->withoutExceptionHandling();

        $requestsCount = WeeklyRequest::count();
        $this->assertDatabaseCount('weekly_requests', $requestsCount);

        $ownerId = User::whereRelation('userClass', 'name', '!=', 'admin')
            ->value('id');
        $serviceId = Service::value('id');

        $expectedAttributes = [
            'owner_id' => $ownerId,
            'service_id' => $serviceId,
            'date' => '2022/01/25',
            'is_authorized' => 0
        ];
        
        $response = $this->postJson('api/weekly-requests', $expectedAttributes);
        
        $this->assertDatabaseCount('weekly_requests', $requestsCount + 1);
        
        $this->assertDatabaseHas('weekly_requests', $expectedAttributes);
        $response->assertStatus(200);
    }

    public function test_a_request_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedWeeklyRequest = WeeklyRequest::first();

        $response = $this->getJson('api/weekly-requests/' . $expectedWeeklyRequest->id);

        $response->assertStatus(200);

        $request = $response->original['data'];

        $this->assertEquals($expectedWeeklyRequest->getAttributes(), $request->getAttributes());
    }

    public function test_a_request_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $request = WeeklyRequest::first();
        $newDate = (Carbon::now())->toDateTimeString();

        $response = $this->putJson('api/weekly-requests/' . $request->id, [
            'date' => $newDate
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('weekly_requests', [
            'id' => $request->id,
            'date' => $newDate
        ]);
    }

    public function test_a_request_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $request = WeeklyRequest::first();

        $response = $this->deleteJson('api/weekly-requests/' . $request->id);

        $response->assertStatus(200);

        $this->assertDeleted($request);
    }
}