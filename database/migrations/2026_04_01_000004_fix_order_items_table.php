<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Rename price_at_purchase to unit_price to match codebase
            if (Schema::hasColumn('order_items', 'price_at_purchase')) {
                $table->renameColumn('price_at_purchase', 'unit_price');
            }

            // Add timestamps if missing
            if (!Schema::hasColumn('order_items', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (!Schema::hasColumn('order_items', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'unit_price')) {
                $table->renameColumn('unit_price', 'price_at_purchase');
            }
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
};
