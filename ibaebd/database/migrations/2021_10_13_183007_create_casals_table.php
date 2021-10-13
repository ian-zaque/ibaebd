<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('esposo_id');
            $table->foreignId('esposa_id');

            $table->integer('qntd_filhos');
            $table->date('casamento');
            $table->string('logradouro');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('num');
            $table->string('cep')->nullable();
            $table->string('complemento')->nullable();

            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('esposo_id')->references('id')->on('esposos');
            $table->foreign('esposa_id')->references('id')->on('esposas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casals');
    }
}
