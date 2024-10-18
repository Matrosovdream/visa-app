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
        Schema::create('order_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->on('orders');
            $table->foreignId('user_id')->on('users')->nullable();
            $table->text('action');
            $table->text('comment')->nullable();
            $table->longText('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_history');
    }
};
