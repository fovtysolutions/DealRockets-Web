<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE chats_others MODIFY COLUMN receiver_type ENUM('seller','admin','customer') NULL");
        Schema::table('chats_others', function (Blueprint $table) {
            $table->unsignedBigInteger('stocksell_id')->nullable()->after('type');
        
            $table->foreign('stocksell_id')
                  ->references('id')
                  ->on('stock_sell')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE chats_others MODIFY COLUMN receiver_type ENUM('seller','admin') NULL");
        Schema::table('chats_others',function(Blueprint $table){
            $table->dropForeign('chats_others_stocksell_id_foreign');
            $table->dropColumn('stocksell_id');
        });
    }
};
