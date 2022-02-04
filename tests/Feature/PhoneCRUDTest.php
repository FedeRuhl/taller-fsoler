<?php

namespace Tests\Feature;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Phone;
use App\Models\Supplier;
use Tests\TestCaseWithSeed;
use App\Models\Hospitalization;
use App\Models\Person;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PhoneCRUDTest extends TestCaseWithSeed
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_phones_can_be_indexed_by_person()
    {
        $this->withoutExceptionHandling();

        $personId = Person::has('phones')->value('id');

        $expectedCount = Phone::where('person_id', $personId)
            ->count();

        $response = $this->getJson('api/phones/person/' . $personId);

        $response->assertStatus(200);

        $phones = $response->original['data'];

        $this->assertCount($expectedCount, $phones);
    }

    public function test_a_phone_can_be_created()
    {
        $this->withoutExceptionHandling();

        $personId = Person::value('id');

        $phonesCount = Phone::where('person_id', $personId)
            ->count();

        $expectedAttributes = [
            'person_id' => $personId,
            'number' => '123456'
        ];
        
        $response = $this->postJson('api/phones', $expectedAttributes);
        
        $phonesCounNow = Phone::where('person_id', $personId)
            ->count();

        $this->assertEquals($phonesCount + 1, $phonesCounNow);
        
        $this->assertDatabaseHas('phones', $expectedAttributes);
        $response->assertStatus(200);
    }

    public function test_a_phone_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedPhone = Phone::first();

        $response = $this->getJson('api/phones/' . $expectedPhone->id);

        $response->assertStatus(200);

        $phone = $response->original['data'];

        $this->assertEquals($expectedPhone->getAttributes(), $phone->getAttributes());
    }

    public function test_a_phone_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $phone = Phone::with('person')->first();
        $person = $phone->person;

        $response = $this->putJson('api/phones/' . $phone->id, [
            'number' => '147258369'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('phones', [
            'id' => $phone->id,
            'person_id' => $person->id,
            'number' => '147258369'
        ]);
    }

    public function test_a_phone_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $phone = Phone::with('person')->first();
        $person = $phone->person;

        $response = $this->deleteJson('api/phones/' . $phone->id);

        $response->assertStatus(200);

        $this->assertModelExists($person); // siga existiendo el user

        $this->assertDeleted($phone);
    }
}