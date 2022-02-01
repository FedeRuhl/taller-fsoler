<?php

namespace Tests\Feature;

use App\Models\Hospitalization;
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
        $this->assertDatabaseCount('hospitalizations', $hospitalizationsCount);

        $patientId = Patient::value('id');
        $serviceId = Service::value('id');

        $expectedAttributes = [
            'patient_id' => $patientId,
            'service_id' => $serviceId,
            'is_ambulatory' => 1,
            'start_date' => '2022/01/31 09:00',
            // 'end_date' => null,
        ];
        
        $response = $this->postJson('api/hospitalizations', $expectedAttributes);
        
        $this->assertDatabaseCount('hospitalizations', $hospitalizationsCount + 1);
        
        $this->assertDatabaseHas('hospitalizations', $expectedAttributes);
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
            'end_date' => $endDate
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('hospitalizations', [
            'id' => $hospitalization->id,
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
}