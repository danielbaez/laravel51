<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailCallOperation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compare_pe.DETAIL_CALLS_OPERATION', function (Blueprint $table) {
       
            $table->increments('id');
            $table->integer('call_id')->unsigned();
            $table->integer('agent_id')->unsigned();
            $table->integer('time');  
            $table->foreign('call_id')->references('id')->on('DETAIL_OPERATION');
            $table->foreign('agent_id')->references('id')->on('panel.users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('compare_pe.DETAIL_CALLS_OPERATION');
    }
}
