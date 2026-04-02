<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Use raw SQL to avoid doctrine/dbal dependency.
        // refund_requests.order_id / user_id are INT UNSIGNED but orders.id / users.id are INT (signed).
        // Change to INT (signed) to match, then add FK constraints.
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Drop any existing FK constraints (they don't exist yet, but be safe)
        try { DB::statement('ALTER TABLE refund_requests DROP FOREIGN KEY refund_requests_order_id_foreign'); } catch (\Exception $e) {}
        try { DB::statement('ALTER TABLE refund_requests DROP FOREIGN KEY refund_requests_user_id_foreign'); } catch (\Exception $e) {}

        // Change INT UNSIGNED -> INT to match orders.id and users.id (which are INT)
        DB::statement('ALTER TABLE refund_requests MODIFY order_id INT NOT NULL');
        DB::statement('ALTER TABLE refund_requests MODIFY user_id INT NOT NULL');

        // Add foreign key constraints
        DB::statement('ALTER TABLE refund_requests ADD CONSTRAINT refund_requests_order_id_foreign FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE refund_requests ADD CONSTRAINT refund_requests_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        try { DB::statement('ALTER TABLE refund_requests DROP FOREIGN KEY refund_requests_order_id_foreign'); } catch (\Exception $e) {}
        try { DB::statement('ALTER TABLE refund_requests DROP FOREIGN KEY refund_requests_user_id_foreign'); } catch (\Exception $e) {}

        DB::statement('ALTER TABLE refund_requests MODIFY order_id INT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE refund_requests MODIFY user_id INT UNSIGNED NOT NULL');
    }
};
