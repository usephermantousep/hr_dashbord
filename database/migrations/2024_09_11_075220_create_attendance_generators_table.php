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
        Schema::create('attendance_generators', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('generate_at')
                ->nullable();
            $table->boolean('is_generated')
                ->default(false);
            $table->unsignedBigInteger('create_by');
            $table->foreign('create_by')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            $table->unsignedBigInteger('generate_by');
            $table->foreign('generate_by')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_generators');
    }
};
