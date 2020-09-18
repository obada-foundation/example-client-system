<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStructuredDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structured_data', function (Blueprint $table) {
            $table->id();
            $table->integer('device_id');
            $table->integer('structured_data_type_id');
            $table->string('structured_data_type');
            $table->json('data_array');
            $table->string('data_hash');
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
        Schema::dropIfExists('structured_data');
    }
}
