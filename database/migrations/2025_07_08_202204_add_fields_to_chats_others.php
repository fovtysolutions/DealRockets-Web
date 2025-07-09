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
        Schema::table('chats_others', function (Blueprint $table) {
            $table->enum('category', ['chat', 'notification'])->default('chat')->after('id');
            $table->string('title')->nullable()->after('receiver_type');
            $table->string('action_url')->nullable()->after('message');
            $table->enum('priority', ['low', 'normal', 'high'])->default('normal')->after('action_url');
            $table->timestamp('read_at')->nullable()->after('is_read');
            $table->boolean('chat_initiator')->nullable();
            $table->uuid('chat_id')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats_others', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'title',
                'action_url',
                'priority',
                'read_at',
                'chat_initiator',
                'chat_id',
            ]);
        });
    }
};
