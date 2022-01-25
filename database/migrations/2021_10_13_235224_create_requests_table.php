<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('owner_id'); //personal de sanidad
            $table->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('hospitalization_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('date');

            $table->boolean('is_authorized')->default(false);

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
        Schema::table('requests', function (Blueprint $table) {
            $dbDriver = DB::getDriverName();

            if ($dbDriver !== 'sqlite')
            {
                $table->dropForeign('owner_id');
                $table->dropForeign('hospitalization_id');
            }
        });

        Schema::dropColumns('requests', ['owner_id']);
        Schema::dropColumns('requests', ['hospitalization_id']);

        Schema::dropIfExists('requests');
    }
}
