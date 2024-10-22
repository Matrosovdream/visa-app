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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->on('users')->nullable();
            $table->foreignId('order_id')->on('orders');
            $table->string('payment_gateway_id');
            $table->string('transaction_id');
            $table->string('status');
            $table->string('currency');
            $table->decimal('amount', 10, 2);
            $table->text('payment_response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
