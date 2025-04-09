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
        Schema::table('tradeshows', function (Blueprint $table) {
            // Rename the existing column 'show_date' to 'start_date' if it already exists
            if (Schema::hasColumn('tradeshows', 'show_date')) {
                $table->renameColumn('show_date', 'start_date');
            } else {
                $table->date('start_date')->nullable();
            }
    
            $table->date('end_date')->nullable(); // Add new end date field
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tradeshows', function (Blueprint $table) {
            // Rename back if renamed
            if (Schema::hasColumn('tradeshows', 'start_date')) {
                $table->renameColumn('start_date', 'show_date');
            }
    
            $table->dropColumn('end_date');
        });
    }
};
