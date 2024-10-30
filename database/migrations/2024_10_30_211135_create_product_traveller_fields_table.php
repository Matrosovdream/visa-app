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
        Schema::create('product_traveller_fields_link', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->on('products');
            $table->foreignId('field_id')->on('product_traveller_fields');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_traveller_fields');
    }
};
