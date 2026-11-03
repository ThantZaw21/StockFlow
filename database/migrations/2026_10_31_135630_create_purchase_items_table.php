<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();

            // Purchase this item belongs to
            $table->foreignId('purchase_id')
                ->constrained()
                ->cascadeOnDelete();

            // Product being purchased
            $table->foreignId('product_id')
                ->constrained()
                ->restrictOnDelete();

            // Number of units purchased
            $table->unsignedInteger('quantity');

            // Purchase price per unit
            $table->decimal('unit_price', 12, 2);

            // Total price for this item (quantity * unit price)
            $table->decimal('subtotal', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
