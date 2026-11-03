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

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            // Product whose stock is changing
            $table->foreignId('product_id')
                ->constrained()
                ->restrictOnDelete();

            // Type of movement: in or out
            $table->enum('type', ['in', 'out']);

            // Number of units moved
            $table->unsignedInteger('quantity');

            $table->unsignedInteger('balance_after');

            // Reason for the stock movement
            $table->string('reason')->nullable();

            // Optional additional notes
            $table->text('notes')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
