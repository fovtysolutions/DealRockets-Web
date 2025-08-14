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
        Schema::table('memberships', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('memberships', 'membership_tier_id')) {
                $table->foreignId('membership_tier_id')->nullable()->after('membership_id')->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('memberships', 'starts_at')) {
                $table->timestamp('starts_at')->nullable()->after('amount');
            }
            if (!Schema::hasColumn('memberships', 'expires_at')) {
                $table->timestamp('expires_at')->nullable()->after('starts_at');
            }
            if (!Schema::hasColumn('memberships', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable()->after('expires_at');
            }
            if (!Schema::hasColumn('memberships', 'usage_tracking')) {
                $table->json('usage_tracking')->nullable()->after('cancelled_at'); // Track feature usage
            }
            if (!Schema::hasColumn('memberships', 'metadata')) {
                $table->json('metadata')->nullable()->after('usage_tracking');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $columnsToCheck = ['membership_tier_id', 'starts_at', 'expires_at', 'cancelled_at', 'usage_tracking', 'metadata'];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('memberships', $column)) {
                    if ($column === 'membership_tier_id') {
                        $table->dropForeign(['membership_tier_id']);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};
