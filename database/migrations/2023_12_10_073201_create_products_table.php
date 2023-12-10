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
            $table->unsignedBigInteger('product_category_id'); # 商品類型編號
            $table->unsignedBigInteger('seller_id'); # 賣家編號
            $table->string('name');
            $table->string('image_url');
            $table->integer('price');
            $table->integer('inventory');
            $table->string('detail');
            $table->integer('status'); # 商品狀態
            $table->timestamps();
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
