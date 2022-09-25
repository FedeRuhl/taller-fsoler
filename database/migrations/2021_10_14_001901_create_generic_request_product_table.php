<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenericRequestProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generic_request_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('generic_request_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('depot_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('products_quantity');

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
        Schema::table('generic_request_product', function (Blueprint $table) {
            $dbDriver = DB::getDriverName();

            if ($dbDriver !== 'sqlite')
            {
                $table->dropForeign('generic_request_id');
                $table->dropForeign('product_id');
                $table->dropForeign('depot_id');
            }
        });

        Schema::dropColumns('generic_request_product', ['generic_request_id']);
        Schema::dropColumns('generic_request_product', ['product_id']);
        Schema::dropColumns('generic_request_product', ['depot_id']);

        Schema::dropIfExists('generic_request_product');
    }
}
