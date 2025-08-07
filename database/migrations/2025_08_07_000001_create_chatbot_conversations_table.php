<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chatbot_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('message');
            $table->boolean('is_bot')->default(false);
            $table->enum('message_type', ['text', 'product_list', 'order_list', 'form', 'contact_info', 'help_menu', 'category_list', 'form_submission'])->default('text');
            $table->json('metadata')->nullable();
            $table->string('sentiment')->nullable();
            $table->decimal('confidence_score', 5, 4)->nullable();
            $table->timestamps();

            $table->index(['session_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_conversations');
    }
};