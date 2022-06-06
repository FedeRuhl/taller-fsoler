<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->foreignId('person_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('unit_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('os_number')->index(); // número de obra social

            $table->boolean('is_military');

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
        Schema::table('patients', function (Blueprint $table) {
            $dbDriver = DB::getDriverName();

            if ($dbDriver !== 'sqlite')
            {
                $table->dropForeign('person_id');
                $table->dropForeign('unit_id');
            }
        });

        Schema::dropColumns('patients', ['person_id']);
        Schema::dropColumns('patients', ['unit_id']);

        Schema::dropIfExists('patients');
    }
}
