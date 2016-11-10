<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailOperation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compare_pe.DETAIL_OPERATION', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('call_id');
            $table->integer('agent_id')->unsigned();
            $table->integer('time'); 
            $table->integer('operation');     
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
        Schema::drop('compare_pe.DETAIL_OPERATION');
    }
}
