<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->integer('type')->unsigned();
            $table->integer('company_id');
            //$table->integer('company_id')->unsigned();
            //$table->foreign('company')->references('CO_COMPANY_ID')->on('compare_pe.PE_COMPANIES');
            //$table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('type')->references('id')->on('type');
            $table->string('country');
            $table->string('phone_pe');
            $table->string('phone_mx');
            $table->boolean('active');
            $table->string('method_call');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
