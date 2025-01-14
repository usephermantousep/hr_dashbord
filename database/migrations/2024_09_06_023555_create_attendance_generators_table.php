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
            $table->string('file');
            $table->string('file_name');
            $table->string('document_number')
                ->unique();
            $table->boolean('is_generated')
                ->default(false);
            $table->foreignId('create_by')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            $table->unsignedBigInteger('generate_by')
                ->nullable();
            $table->foreign('generate_by')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            $table->longText('error_message')
                ->nullable();
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
