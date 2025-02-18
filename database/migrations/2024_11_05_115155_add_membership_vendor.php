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
        Schema::table('sellers',function(Blueprint $table){
            $table->bigInteger('membership_id');
            $table->bigInteger('chat_id');
            $table->string('membership_status');
            $table->string('current_chatrooms');
            $table->string('vendor_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers',function(Blueprint $table){
            $table->dropColumn('membership_id');
            $table->dropColumn('chat_id');
            $table->dropColumn('membership_status');
            $table->dropColumn('current_chatrooms');
            $table->dropColumn('vendor_type');
        });
    }
};
