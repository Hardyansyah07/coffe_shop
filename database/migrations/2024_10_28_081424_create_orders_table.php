<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('no_meja');
            $table->unsignedDecimal('subtotal', 10, 2);
            $table->unsignedDecimal('tax', 10, 2)->default(0); // Tambahkan pajak 11%
            $table->unsignedDecimal('total', 10, 2); // Total setelah pajak
            $table->unsignedDecimal('uang_dibayar', 10, 2)->nullable();
            $table->unsignedDecimal('kembalian', 10, 2)->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('order_status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['Cash', 'Bank Transfer', 'E-Wallet'])->nullable()->default('Cash');
            $table->json('payment_details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
