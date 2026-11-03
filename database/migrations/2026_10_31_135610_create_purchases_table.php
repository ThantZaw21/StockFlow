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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            //supplier associated with this purchase
            $table->foreignId('supplier_id')
                ->constrained()
                ->restrictOnDelete();
            // Date when the purchase was made
            $table->date('purchase_date');

            // Total cost of this purchase
            $table->decimal('total_amount', 12, 2)->default(0);

            // Current purchase status
            $table->enum('status', ['pending', 'received', 'cancelled'])
                ->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
