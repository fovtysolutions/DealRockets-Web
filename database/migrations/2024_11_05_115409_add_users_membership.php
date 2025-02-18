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
        Schema::table('users',function(Blueprint $table){
            $table->bigInteger('membership_id');
            $table->string('membership');
            $table->bigInteger('chat_id');
            $table->string('membership_status');
            $table->string('current_chatrooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users',function(Blueprint $table){
            $table->dropColumn('membership_id');
            $table->dropColumn('membership');
            $table->dropColumn('chat_id');
            $table->dropColumn('membership_status');
            $table->dropColumn('current_chatrooms');
        });
    }
};
