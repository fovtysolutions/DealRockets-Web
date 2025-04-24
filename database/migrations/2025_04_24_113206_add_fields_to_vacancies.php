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
        Schema::table('vacancies', function (Blueprint $table) {
            $table->string('currency');
            $table->renameColumn('salary', 'salary_low');
            $table->string('salary_high');
            $table->string('company_employees');
            $table->string('company_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn([
                'currency',
                'salary_high',
                'company_employees',
                'company_type'
            ]);
            $table->renameColumn('salary_low', 'salary');
        });
    }
};
