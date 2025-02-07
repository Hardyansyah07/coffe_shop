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
            $table->integer('no_meja');
            $table->decimal('subtotal', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending'); // Status pembayaran
            $table->enum('order_status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending'); // Status pesanan
            $table->enum('payment_method', ['Cash', 'Bank Transfer', 'E-Wallet']);
            $table->json('payment_details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
