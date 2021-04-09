<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('cpf')->unique();
            $table->string('rg')->unique();
            $table->string('orgao_emissor');
            $table->string('uf');
            $table->string('email')->nullable();
            $table->string('classe');
            $table->date('nascimento');
            $table->date('conversao')->nullable();
            $table->boolean('isEvangelico')->default(false);
            $table->boolean('isMembro')->default(false);
            $table->boolean('sexo')->default(false);
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
}
