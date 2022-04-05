<?php

namespace Tests\Feature;

use App\Models\Hospitalization;
use App\Models\HospitalizationHistory;
use App\Models\Patient;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCaseWithSeed;

class HospitalizationCRUDTest extends TestCaseWithSeed
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_hospitalizations_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = Hospitalization::count();

        $response = $this->getJson('api/hospitalizations');

        $response->assertStatus(200);

        $hospitalizations = $response->original['data'];

        $this->assertCount($expectedCount, $hospitalizations);
    }

    public function test_a_hospitalization_can_be_created()
    {
        $this->withoutExceptionHandling();

        $hospitalizationsCount = Hospitalization::count();
        $hospitalizationHistoriesCount = HospitalizationHistory::count();

        $patientId = Patient::value('id');
        $serviceId = Service::value('id');

        $hospitalizationExpectedAttributes = [
            'patient_id' => $patientId,
            'is_ambulatory' => 1
        ];

        $hospitalizationHistoryExpectedAttributes = [
            'service_id' => $serviceId,
            'start_date' => '2022/01/31 09:00'
        ];
        
        $response = $this->postJson('api/hospitalizations', array_merge($hospitalizationExpectedAttributes, $hospitalizationHistoryExpectedAttributes));
        
        $this->assertDatabaseCount('hospitalizations', $hospitalizationsCount + 1);
        $this->assertDatabaseHas('hospitalizations', $hospitalizationExpectedAttributes);
        
        $this->assertDatabaseCount('hospitalization_histories', $hospitalizationHistoriesCount + 1);
        $this->assertDatabaseHas('hospitalization_histories', $hospitalizationHistoryExpectedAttributes);

        $response->assertStatus(200);
    }

    public function test_a_hospitalization_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedHospitalization = Hospitalization::first();

        $response = $this->getJson('api/hospitalizations/' . $expectedHospitalization->id);

        $response->assertStatus(200);

        $hospitalization = $response->original['data'];

        $this->assertEquals($expectedHospitalization->getAttributes(), $hospitalization->getAttributes());
    }

    public function test_a_hospitalization_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $hospitalization = Hospitalization::first();
        $endDate = (Carbon::now())->toDateTimeString();

        $response = $this->putJson('api/hospitalizations/' . $hospitalization->id, [
            'is_ambulatory' => 0,
            'end_date' => $endDate
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('hospitalizations', [
            'id' => $hospitalization->id,
            'is_ambulatory' => 0
        ]);

        $this->assertDatabaseHas('hospitalization_histories', [
            'hospitalization_id' => $hospitalization->id,
            'end_date' => $endDate
        ]);
    }

    public function test_a_hospitalization_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $hospitalization = Hospitalization::first();

        $response = $this->deleteJson('api/hospitalizations/' . $hospitalization->id);

        $response->assertStatus(200);

        $this->assertDeleted($hospitalization);
    }

    public function test_a_hospitalizacion_can_change_service()
    {
        $this->withoutExceptionHandling();

        $hospitalization = Hospitalization::with(['histories', 'currentHistory'])
            ->first();

        $oldServiceId = $hospitalization->currentHistory->first()->value('service_id');
        $serviceId = Service::where('id', '!=', $oldServiceId)->value('id');

        $endDate = (Carbon::now())->toDateTimeString();

        $response = $this->postJson('api/hospitalizations/' . $hospitalization->id . '/change-service', [
            'service_id' => $serviceId
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('hospitalization_histories', [
            'hospitalization_id' => $hospitalization->id,
            'service_id' => $oldServiceId,
            'end_date' => $endDate
        ]);

        $this->assertDatabaseHas('hospitalization_histories', [
            'hospitalization_id' => $hospitalization->id,
            'service_id' => $serviceId,
            'start_date' => $endDate
        ]);
    }
}