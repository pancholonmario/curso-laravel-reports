<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExpenseReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_reports', function (Blueprint $table) {
            $table->increments('id');

            //aqui unsigned=es para que no acepte valores negativos
            $table->integer('user_id')->unsigned();
            //aqui no

            $table->timestamps();

            //aqui
            $table->foreign('user_id')->references('id')->on('users');
            //no aqui
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_reports');
    }
}
