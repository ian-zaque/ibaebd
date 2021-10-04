<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscricaoManhaDivertidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscricao_manha_divertidas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome');
            $table->integer('idade');
            $table->string('nome_pai')->nullable();
            $table->string('nome_mae')->nullable();
            $table->string('nome_responsavel')->nullable();
            $table->string('contato');
            $table->boolean('banho_mangueira')->default(false);

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
        Schema::dropIfExists('inscricao_manha_divertidas');
    }
}
