<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nombre');
            $table->string('Representante')->nullable();
            $table->string('Email')->nullable();
            // FK
            $table->integer('giro_id')->unsigned();
            $table->foreign('giro_id')->references('id')->on('giros');

            $table->tinyInteger('fiscal')->unsigned()->default(0);          //  0=No, 1=Si
            $table->tinyInteger('asimilado')->unsigned()->default(0);          //  0=No, 1=Si
            // FK
            $table->integer('fiscal_company_id')->unsigned()->nullable();
            $table->foreign('fiscal_company_id')->references('id')->on('companies');
            // FK
            $table->integer('asimilado_company_id')->unsigned()->nullable();
            $table->foreign('asimilado_company_id')->references('id')->on('companies');

            $table->integer('fiscal_bda')->unsigned()->nullable();
            $table->integer('asimilado_bda')->unsigned()->nullable();

            $table->tinyInteger('Activo')->unsigned()->default(1);          //  0=No, 1=Si
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
        Schema::dropIfExists('clients');
    }
}
