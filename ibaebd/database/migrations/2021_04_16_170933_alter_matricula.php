<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMatricula extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->dropColumn('isMembro')->after('conversao');
            $table->dropColumn('cpf');
            $table->dropColumn('rg');
            $table->dropColumn('orgao_emissor');
            $table->dropColumn('uf');

            $table->enum('membresia',['m','c']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->boolean('isMembro');
            $table->dropColumn('membresia');
            $table->string('cpf')->unique();
            $table->string('rg')->unique();
            $table->string('orgao_emissor');
            $table->string('uf');
        });
    }
}
