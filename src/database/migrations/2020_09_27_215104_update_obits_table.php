<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateObitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_obits', function (Blueprint $table) {
            $table->dropColumn('obit_id');
            $table->string('obitDID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_obits', function (Blueprint $table) {
            $table->string('obit_id');
            $table->dropColumn('obitDID');
        });
    }
}
