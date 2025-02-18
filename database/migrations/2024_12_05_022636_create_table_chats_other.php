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
        Schema::create('chats_others', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id'); // Sender ID
            $table->enum('sender_type', ['customer', 'seller', 'admin']); // Sender type
            $table->unsignedBigInteger('receiver_id'); // Receiver ID
            $table->enum('receiver_type', ['seller', 'admin']); // Receiver type
            $table->text('message'); // Chat message
            $table->boolean('is_read')->default(false); // Whether the message has been read
            $table->timestamp('sent_at')->useCurrent(); // Message sent time
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats_other');
    }
};
