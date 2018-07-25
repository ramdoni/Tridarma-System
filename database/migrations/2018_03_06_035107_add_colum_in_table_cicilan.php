<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumInTableCicilan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cicilan', function (Blueprint $table) {
            $table->integer('sisa_pokok')->nullable();
            $table->integer('angsuran')->nullable();
            $table->integer('pokok')->nullable();
            $table->integer('provisi')->nullable();
            $table->integer('jasa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cicilan', function (Blueprint $table) {
            //
        });
    }
}
