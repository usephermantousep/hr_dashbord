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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')
                ->unique();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('restrict');
            $table->unsignedBigInteger('attendance_status_id');
            $table->foreign('attendance_status_id')
                ->references('id')
                ->on('attendance_statuses')
                ->onDelete('restrict');
            $table->date('date');
            $table->unsignedBigInteger('generate_id')
                ->nullable();
            $table->foreign('generate_id')
                ->references('id')
                ->on('attendance_generators')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
