<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('description');
            $table->char('ean', 13)->unique();
            // $table->decimal('price', 10, 2); // VER A POSSIBILIDADE DE DESENVOLVER TABELA DE PRECOS
            // $table->unsignedBigInteger('stock_id');
            // $table->unsignedBigInteger('departament_id');
            // $table->unsignedBigInteger('price_id');

            // $table->foreign('stock_id')->references('id')->on('stocks');
            // $table->foreign('departament_id')->references('id')->on('departaments');
            // $table->foreign('price_id')->references('id')->on('prices'); 
            
            // QUANDO FOR CADASTRAR PRICE NA PRICETYPES, CADASTRAR EM CENTAVOS, NO CASO R$ 1,00 = 100 CENTAVOS E ASSIM O PRICE VAI SER INTEIRO SEMPRE
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
