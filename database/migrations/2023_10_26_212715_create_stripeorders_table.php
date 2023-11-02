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
        Schema::create('stripeorders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->integer('country');
            $table->integer('city');
            $table->integer('zip');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('message')->nullable();
            $table->integer('ship_check')->nullable();
            $table->string('ship_fname')->nullable();
            $table->string('ship_lname')->nullable();
            $table->integer('ship_country')->nullable();
            $table->integer('ship_city')->nullable();
            $table->integer('ship_zip')->nullable();
            $table->string('ship_company')->nullable();
            $table->string('ship_email')->nullable();
            $table->string('ship_phone')->nullable();
            $table->string('ship_address')->nullable();
            $table->integer('charge');
            $table->integer('discount');
            $table->integer('total');
            $table->integer('sub_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripeorders');
    }
};
