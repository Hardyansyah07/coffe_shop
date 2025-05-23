<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi');
            $table->integer('harga');
            $table->string('image');
            $table->string('category_id');
            $table->integer('stok')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus', function (Blueprint $table){
            $table->dropColumn('is_active');
            $table->dropColumn('category_id');
            $table->dropColumn('stok');
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
        });
    }
}
