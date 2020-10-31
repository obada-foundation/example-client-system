<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientObitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_obits', function (Blueprint $table) {
            $table->id();
            $table->string('obit_did');
            $table->string('usn');
            $table->string('owner_did');
            $table->string('obd_did');
            $table->enum('obit_status',['FUNCTIONAL','NON_FUNCTIONAL','DISPOSED','STOLEN','DISABLED_BY_OWNER']);
            $table->string('manufacturer');
            $table->string('part_number');
            $table->string('serial_number_hash');
            $table->json('metadata');
            $table->json('documents');
            $table->json('structured_data');
            $table->string('root_hash');
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
        Schema::dropIfExists('client_obits');
    }
}
