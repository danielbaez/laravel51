<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailCall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compare_pe.DETAIL_CALLS', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('call_id');
            $table->integer('agent_id');
            $table->integer('time');     
            $table->foreign('call_id')->references('id')->on('compare_pe.LOG_CALLS');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
