<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add missing updated_at timestamp
            $table->timestamp('updated_at')->nullable()->after('created_at');

            // Rename total_price to total_amount to match codebase
            $table->renameColumn('total_price', 'total_amount');

            // Add missing columns
            $table->string('shipping_address')->nullable()->after('payment_method');
            $table->text('notes')->nullable()->after('shipping_address');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('updated_at');
            $table->renameColumn('total_amount', 'total_price');
            $table->dropColumn(['shipping_address', 'notes']);
        });
    }
};
