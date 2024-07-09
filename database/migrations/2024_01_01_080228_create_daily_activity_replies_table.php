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
        Schema::create(
            'daily_activity_replies', function (Blueprint $table){
            $table->id();
            $table->integer('daily_activity_id');
            $table->integer('user')->default(0);
            $table->text('description')->nullable();
            $table->integer('created_by');
            $table->integer('is_read')->default('0');
            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activity_replies');
    }
};
