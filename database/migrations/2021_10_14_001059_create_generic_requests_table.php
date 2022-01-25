<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenericRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Listados
        Schema::create('generic_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('request_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('generic_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('generics_total_quantity');

            $table->integer('generics_consumed_quantity');

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
        Schema::table('generic_requests', function (Blueprint $table) {
            $dbDriver = DB::getDriverName();

            if ($dbDriver !== 'sqlite')
            {
                $table->dropForeign('request_id');
                $table->dropForeign('generic_id');
            }
        });

        Schema::dropColumns('generic_requests', ['request_id']);
        Schema::dropColumns('generic_requests', ['generic_id']);

        Schema::dropIfExists('generic_requests');
    }
}
