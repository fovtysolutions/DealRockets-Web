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
        Schema::create('stock_sell', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description");
            $table->integer("quantity");
            $table->foreignId("product_id")->constrained('products')->onDelete("cascade");
            $table->enum("status",['active','inactive','rejected']);
            $table->integer("user_id");
            $table->string("role");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_sell');
    }
};
