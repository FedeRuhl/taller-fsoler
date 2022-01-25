<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepotProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depot_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('depot_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('stock')->nullable();

            $table->date('expiration_date')->nullable();

            $table->string('lote_code')->nullable();

            $table->timestamps();

            $table->index(['depot_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('depot_product', function (Blueprint $table) {
            $dbDriver = DB::getDriverName();

            if ($dbDriver !== 'sqlite')
            {
                $table->dropForeign('depot_id');
                $table->dropForeign('product_id');
            }
        });

        Schema::dropColumns('depot_product', ['depot_id']);
        Schema::dropColumns('depot_product', ['product_id']);

        Schema::dropIfExists('depot_product');
    }
}
