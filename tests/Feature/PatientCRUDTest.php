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
        
        $peopleCount = Person::count();
        $this->assertDatabaseCount('people', $peopleCount);

        $patientsCount = Patient::count();
        $this->assertDatabaseCount('patients', $patientsCount);
        
        $unitId = Unit::value('id');
        
        $personExpectedAttributes = [
            'dni' => 45369865,
            'first_name' => 'Marcos',
            'last_name' => 'Diaz',
            'birth_date' => '2005-01-01'
        ];
        
        $patientExpectedAttributes = [
            'unit_id' => $unitId,
            'os_number' => '123456',
            // 'status' => '',
            'is_military' => 1
        ];
        
        $parameters = array_merge($personExpectedAttributes, $patientExpectedAttributes);
        
        $response = $this->postJson('api/patients', $parameters);
        
        $response->assertStatus(200);

        $this->assertDatabaseCount('people', $peopleCount + 1);
        $this->assertDatabaseHas('people', $personExpectedAttributes);

        $this->assertDatabaseCount('patients', $patientsCount + 1);
        $this->assertDatabaseHas('patients', $patientExpectedAttributes);
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
        $person = $patient->person;

        $response = $this->putJson('api/patients/' . $patient->id, [
            'first_name' => 'Juan',
            'os_number' => '789101'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('people', [
            'id' => $person->id,
            'first_name' => 'Juan',
        ]);

        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'os_number' => '789101',
            'person_id' => $person->id
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