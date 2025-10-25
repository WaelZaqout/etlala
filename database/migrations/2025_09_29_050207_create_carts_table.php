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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // المستخدم صاحب السلة
            $table->unsignedBigInteger('user_id');

            // المنتج داخل السلة
            $table->unsignedBigInteger('product_id');

            // الكمية
            $table->integer('quantity')->default(1);

            $table->timestamps();

            // لإضافة العلاقات
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // منع تكرار نفس المنتج لنفس المستخدم في السلة
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
