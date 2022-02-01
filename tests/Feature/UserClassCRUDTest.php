<?php

namespace Tests\Feature;

use App\Models\UserClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserClassCRUDTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_user_classes_can_be_indexed()
    {
        $this->withoutExceptionHandling();

        $expectedCount = 10;

        UserClass::factory()->count($expectedCount)->create();

        $response = $this->getJson('api/user-classes');

        $response->assertStatus(200);

        $user_classes = $response->original['data'];

        $this->assertCount($expectedCount, $user_classes);
    }

    public function test_a_user_class_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->assertDatabaseCount('user_classes', 0);

        $response = $this->postJson('api/user-classes', [
            'name' => 'Clase de usuario N° 1'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseCount('user_classes', 1);

        $this->assertDatabaseHas('user_classes', [
            'name' => 'Clase de usuario N° 1'
        ]);
    }

    public function test_a_user_class_can_be_showed()
    {
        $this->withoutExceptionHandling();

        $expectedUserClass = UserClass::create([
            'name' => 'Clase de usuario N° 1'
        ]);

        $response = $this->getJson('api/user-classes/' . $expectedUserClass->id);

        $response->assertStatus(200);

        $user_class = $response->original['data'];

        $this->assertEquals($expectedUserClass->getAttributes(), $user_class->getAttributes());
    }

    public function test_a_user_class_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $userClass = UserClass::create([
            'name' => 'Clase de usuario N° 1'
        ]);

        $response = $this->putJson('api/user-classes/' . $userClass->id, [
            'name' => 'Clase de usuario N° 1 actualizada!'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('user_classes', [
            'id' => $userClass->id,
            'name' => 'Clase de usuario N° 1 actualizada!'
        ]);
    }

    public function test_a_user_class_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $userClass = UserClass::create([
            'name' => 'Clase de usuario N° 1'
        ]);

        $response = $this->deleteJson('api/user-classes/' . $userClass->id);

        $response->assertStatus(200);

        $this->assertDeleted($userClass);
    }
}