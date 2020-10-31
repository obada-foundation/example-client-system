<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('owner');
            $table->string('manufacturer');
            $table->string('part_number');
            $table->string('serial_number');
            $table->string('usn');
            $table->enum('status',['FUNCTIONAL','NON_FUNCTIONAL','DISPOSED','STOLEN','DISABLED_BY_OWNER']);
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
        Schema::dropIfExists('devices');
    }
}
