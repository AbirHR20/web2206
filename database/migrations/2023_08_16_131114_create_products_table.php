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
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('brand_id')->nullable();
            $table->string('product_name');
            $table->integer('product_price');
            $table->integer('product_discount')->nullable();
            $table->integer('after_product_discount');
            $table->string('tages');
            $table->string('short_desp')->nullable();
            $table->longText('long_desp');
            $table->longText('add_info')->nullable();
            $table->string('preview');
            $table->string('slug');
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
