<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Models\User;
use App\Models\UserClass;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCaseWithSeed;

class UserCRUDTest extends TestCaseWithSeed
{
    // TODO: agregar endpoint para agregar relación con teléfono, también hacerlo en pacientes
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_users_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = User::count();

        $response = $this->getJson('api/users');

        $response->assertStatus(200);

        $users = $response->original['data'];

        $this->assertCount($expectedCount, $users);
    }

    public function test_a_user_can_be_created()
    {
        $this->withoutExceptionHandling();
        
        $peopleCount = Person::count();
        $this->assertDatabaseCount('people', $peopleCount);

        $usersCount = User::count();
        $this->assertDatabaseCount('users', $usersCount);
        
        $userClassId = UserClass::where('name', '!=', 'admin')->value('id');
        
        $personExpectedAttributes = [
            'dni' => 45369869,
            'first_name' => 'Juancito',
            'last_name' => 'Diaz',
            'birth_date' => '2005-01-01'
        ];
        
        $userExpectedAttributes = [
            'docket' => '123456',
            'email' => 'juancito@test.com',
            'password' => bcrypt('123123'),
            'user_class_id' => $userClassId
        ];
        
        $parameters = array_merge($personExpectedAttributes, $userExpectedAttributes);
        
        $response = $this->postJson('api/users', $parameters);
        
        $response->assertStatus(200);

        $this->assertDatabaseCount('people', $peopleCount + 1);
        $this->assertDatabaseHas('people', $personExpectedAttributes);

        $this->assertDatabaseCount('users', $usersCount + 1);
        $this->assertDatabaseHas('users', $userExpectedAttributes);
    }

    public function test_a_user_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedUser = User::first();

        $response = $this->getJson('api/users/' . $expectedUser->id);

        $response->assertStatus(200);

        $user = $response->original['data'];

        $this->assertEquals($expectedUser->getAttributes(), $user->getAttributes());
    }

    public function test_a_user_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $user = User::first();
        $person = $user->person;

        $response = $this->putJson('api/users/' . $user->id, [
            'first_name' => 'Pedrito',
            'docket' => '789654'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('people', [
            'id' => $person->id,
            'first_name' => 'Pedrito',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'docket' => '789654',
            'person_id' => $person->id
        ]);
    }

    public function test_a_user_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $user = User::first();

        $response = $this->deleteJson('api/users/' . $user->id);

        $response->assertStatus(200);

        $this->assertDeleted($user);
    }
}