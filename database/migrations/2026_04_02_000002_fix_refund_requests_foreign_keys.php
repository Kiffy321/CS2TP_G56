<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('refund_requests', function (Blueprint $table) {
            // Drop existing foreign keys before altering column types
            $table->dropForeign(['order_id']);
            $table->dropForeign(['user_id']);

            // Change from unsignedInteger to unsignedBigInteger to match orders/users id() columns
            $table->unsignedBigInteger('order_id')->change();
            $table->unsignedBigInteger('user_id')->change();

            // Re-add foreign keys
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('refund_requests', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['user_id']);

            $table->unsignedInteger('order_id')->change();
            $table->unsignedInteger('user_id')->change();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
