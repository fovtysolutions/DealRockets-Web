<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chats_others',function(Blueprint $table){
            DB::statement("ALTER TABLE chats_others ADD COLUMN openstatus ENUM('1','0') DEFAULT '1'");
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats_others',function(Blueprint $table){
            $table->dropColumn('openstatus');
        }); 
    }
};
