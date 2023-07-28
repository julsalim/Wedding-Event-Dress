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
        Schema::create('game_tables', function (Blueprint $table) {
            $table->id();
            $table->string('roomId');
            $table->foreignId('player_1');
            $table->foreignId('player_2')->nullable();
            $table->timestamps();

            $table->foreign('player_1')->references('id')->on('users');
            $table->foreign('player_2')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_tables');
    }
};
