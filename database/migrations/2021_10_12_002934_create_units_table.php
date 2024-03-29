<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();

            $table->foreignId('unit_ubication_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('name');

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
        Schema::table('units', function (Blueprint $table) {
            $dbDriver = DB::getDriverName();

            if ($dbDriver !== 'sqlite')
            {
                $table->dropForeign('unit_ubication_id');
            }
        });

        Schema::dropColumns('units', ['unit_ubication_id']);

        Schema::dropIfExists('units');
    }
}
