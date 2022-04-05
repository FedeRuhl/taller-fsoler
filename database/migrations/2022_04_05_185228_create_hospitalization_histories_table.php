<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalizationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalization_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('hospitalization_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

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
        Schema::table('hospitalization_histories', function (Blueprint $table) {
            $dbDriver = DB::getDriverName();

            if ($dbDriver !== 'sqlite')
            {
                $table->dropForeign('service_id');
                $table->dropForeign('hospitalization_id');
            }
        });

        Schema::dropColumns('hospitalization_histories', ['service_id']);
        Schema::dropColumns('hospitalization_histories', ['hospitalization_id']);

        Schema::dropIfExists('hospitalization_histories');
    }
}
