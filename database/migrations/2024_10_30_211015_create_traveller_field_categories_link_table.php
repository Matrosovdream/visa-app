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
        Schema::create('traveller_field_categories_link', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->on('traveller_field_categories');
            $table->foreignId('field_id')->on('product_traveller_fields');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traveller_field_categories_link');
    }
};
