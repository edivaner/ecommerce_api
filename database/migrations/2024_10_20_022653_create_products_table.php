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
            $table->unsignedBigInteger('department_id');
            $table->char('ean', 13)->unique();            
            $table->string('description');
            $table->decimal('price', 10, 2); // VER A POSSIBILIDADE DE DESENVOLVER TABELA DE PRECOS
            // $table->unsignedBigInteger('price_id');
            
            $table->foreign('department_id')->references('id')->on('departments');
            // $table->foreign('price_id')->references('id')->on('prices');             
            // QUANDO FOR CADASTRAR PRICE NA PRICETYPES, CADASTRAR EM CENTAVOS, NO CASO R$ 1,00 = 100 CENTAVOS E ASSIM O PRICE VAI SER INTEIRO SEMPRE
            $table->timestamps();
            $table->softDeletes();
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
