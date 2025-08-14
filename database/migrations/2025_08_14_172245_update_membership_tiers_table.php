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
        Schema::table('membership_tiers', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('membership_tiers', 'price')) {
                $table->decimal('price', 10, 2)->default(0)->after('membership_name');
            }
            if (!Schema::hasColumn('membership_tiers', 'description')) {
                $table->text('description')->nullable()->after('price');
            }
            if (!Schema::hasColumn('membership_tiers', 'billing_cycle')) {
                $table->string('billing_cycle')->default('monthly')->after('description'); // monthly, yearly, one_time
            }
            if (!Schema::hasColumn('membership_tiers', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('billing_cycle');
            }
            if (!Schema::hasColumn('membership_tiers', 'metadata')) {
                $table->json('metadata')->nullable()->after('is_featured');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_tiers', function (Blueprint $table) {
            $columnsToCheck = ['price', 'description', 'billing_cycle', 'is_featured', 'metadata'];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('membership_tiers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
