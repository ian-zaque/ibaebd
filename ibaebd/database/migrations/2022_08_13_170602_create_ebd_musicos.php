<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbdMusicos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebd_musicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome');
            $table->date('nascimento');
            $table->string('email')->nullable();
            $table->string('telefone');
            $table->integer('tempo_mma');
            $table->integer('tempo_pgm');
            $table->string('pgm');
            $table->string('versiculo');
            $table->enum('naipe_vocal',['Soprano', 'Contralto', 'Tenor', 'Barítono'])->nullable();
            $table->enum('preferencia_horario',['1', '2', '3']);
            $table->json('grupo_mma');
            $table->json('instrumento')->nullable();

            $table->timestampsTz();
            $table->softDeletesTz();

            // nome: '', sobrenome: '', nascimento:'', email:'', telefone:'', grupo_mma:[], tempo_mma:'', instrumento:[],
            //    naipe_vocal:'', pgm:'', tempo_pgm:'', preferencia_horario:'', versiculo:'',
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebd_musicos');
    }
}
