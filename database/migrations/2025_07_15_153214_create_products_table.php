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
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('variant_id')->constrained()->onDelete('cascade');
        $table->foreignId('brand_id')->constrained()->onDelete('cascade');
        $table->unsignedInteger('purchase_price')->default(0); // Harga Beli
        $table->unsignedInteger('selling_price')->default(0);  // Harga Jual
        $table->integer('stock')->default(0);
        $table->boolean('is_featured')->default(false);
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
