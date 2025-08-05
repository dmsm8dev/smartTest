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
        Schema::create('films_genres', function (Blueprint $table) {
            $table->unsignedBigInteger('genres_id');
            $table->unsignedBigInteger('films_id');

            $table->foreign('genres_id')->references('id')->on('genres')->onDelete('cascade');
            $table->foreign('films_id')->references('id')->on('films')->onDelete('cascade');

            $table->primary(['genres_id', 'films_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films_genres');
    }
};
