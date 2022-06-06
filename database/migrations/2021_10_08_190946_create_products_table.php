<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('generic_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

                $table->foreignId('laboratory_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
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
        
        Schema::table('products', function (Blueprint $table) {
            $dbDriver = DB::getDriverName();

            if ($dbDriver !== 'sqlite')
            {
                $table->dropForeign('generic_id');
                $table->dropForeign('laboratory_id');
            }
            
            Schema::dropColumns('products', ['generic_id']);
            Schema::dropColumns('products', ['laboratory_id']);
        });

        Schema::dropIfExists('products');
    }
}
