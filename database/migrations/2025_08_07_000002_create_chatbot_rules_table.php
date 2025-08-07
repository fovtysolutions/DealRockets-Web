<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chatbot_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('pattern');
            $table->text('response');
            $table->enum('response_type', ['text', 'product_list', 'order_list', 'form', 'contact_info', 'help_menu', 'category_list'])->default('text');
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('conditions')->nullable();
            $table->json('actions')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'priority']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_rules');
    }
};