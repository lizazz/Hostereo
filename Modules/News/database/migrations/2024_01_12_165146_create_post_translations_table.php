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
        Schema::create('post_translations', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('language_id');
            $table->string('title');
            $table->text('description');
            $table->text('content');
            $table->timestamps();

            $table
                ->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_translations');
    }
};
