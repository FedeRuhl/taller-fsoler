<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Proveedores
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('supplier_address_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('CUIT', 11)->unique();

            $table->string('company_name'); // razón social

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
        Schema::table('suppliers', function (Blueprint $table) {
            $dbDriver = DB::getDriverName();

            if ($dbDriver !== 'sqlite')
            {
                $table->dropForeign('supplier_address_id');
            }
        });

        Schema::dropColumns('suppliers', ['supplier_address_id']);

        Schema::dropIfExists('suppliers');
    }
}
