<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add the category relationship to the existing products table.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Allow each product to reference a category.
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the changes if this migration is rolled back.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove the foreign key and its column.
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};