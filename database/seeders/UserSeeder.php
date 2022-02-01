<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\User;
use App\Models\UserClass;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $person = Person::factory()->create();
        $userClass = UserClass::where('name', '!=', 'admin')->firstOrFail();

        User::create([
            'person_id' => $person->id,
            'user_class_id' => $userClass->id,
            'docket' => 15975312,
            'username' => 'usuario-de-sanidad',
            'email' => 'sanidad@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        User::factory()->count(10)->create();
    }
}