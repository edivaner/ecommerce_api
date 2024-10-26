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
            $table->decimal('price', 10, 2);
            // $table->unsignedBigInteger('stock_id');
            // $table->unsignedBigInteger('departament_id');

            // $table->foreign('stock_id')->references('id')->on('stocks');
            // $table->foreign('departament_id')->references('id')->on('departaments');
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
