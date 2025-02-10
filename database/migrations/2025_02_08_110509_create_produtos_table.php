<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Executa as migrations.
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');               // Nome do produto
            $table->text('descricao')->nullable();  // Descrição (opcional)
            $table->integer('estoque')->default(0); // Quantidade em estoque
            $table->timestamps();
        });
    }

    /**
     * Reverte as migrations.
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
