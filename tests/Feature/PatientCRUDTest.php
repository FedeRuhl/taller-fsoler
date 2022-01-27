<?php

namespace Tests\Feature;

use App\Models\Hospitalization;
use App\Models\Patient;
use App\Models\Person;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCaseWithSeed;

class PatientCRUDTest extends TestCaseWithSeed
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_patients_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = Patient::count();

        $response = $this->getJson('api/patients');

        $response->assertStatus(200);

        $patients = $response->original['data'];

        $this->assertCount($expectedCount, $patients);
    }

    public function test_a_patient_can_be_created()
    {
        $this->withoutExceptionHandling();

        $patientsCount = Patient::count();
        $this->assertDatabaseCount('patients', $patientsCount);

        $personId = Person::value('id');
        $unitId = Unit::value('id');

        $expectedAttributes = [
            'person_id' => $personId,
            'unit_id' => $unitId,
            'os_number' => '123456',
            // 'status' => '',
            'is_military' => 1
        ];
        
        $response = $this->postJson('api/patients', $expectedAttributes);
        
        $this->assertDatabaseCount('patients', $patientsCount + 1);
        
        $this->assertDatabaseHas('patients', $expectedAttributes);
        $response->assertStatus(200);
    }

    public function test_a_patient_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedPatient = Patient::first();

        $response = $this->getJson('api/patients/' . $expectedPatient->id);

        $response->assertStatus(200);

        $patient = $response->original['data'];

        $this->assertEquals($expectedPatient->getAttributes(), $patient->getAttributes());
    }

    public function test_a_patient_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $patient = Patient::first();

        $response = $this->putJson('api/patients/' . $patient->id, [
            'os_number' => '789101'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'os_number' => '789101'
        ]);
    }

    public function test_a_patient_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $patient = Patient::first();

        $response = $this->deleteJson('api/patients/' . $patient->id);

        $response->assertStatus(200);

        $this->assertDeleted($patient);
    }
}