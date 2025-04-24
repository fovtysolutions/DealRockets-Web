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
        Schema::table('table_job_profiles', function (Blueprint $table) {
            $table->string('currency');
            $table->longText('previous_employers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_job_profiles', function (Blueprint $table) {
            $table->dropColumn('currency');
            $table->dropColumn('previous_employers');
        });
    }
};
