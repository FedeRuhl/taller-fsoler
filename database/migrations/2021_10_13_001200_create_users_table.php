<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // health staff
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->foreignId('person_id')
                ->unique()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('user_class_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('docket')->index(); //legajo

            $table->string('username');

            $table->string('email')->unique();

            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
