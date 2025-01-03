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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')
                ->unique();
            $table->string('name');
            $table->foreignId('branch_id')
                ->references('id')
                ->on('branches')
                ->onDelete('restrict');
            $table->foreignId('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('restrict');
            $table->foreignId('job_position_id')
                ->references('id')
                ->on('job_positions')
                ->onDelete('restrict');
            $table->foreignId('employment_status_id')
                ->references('id')
                ->on('employment_statuses')
                ->onDelete('restrict');
            $table->foreignId('employment_type_id')
                ->references('id')
                ->on('employment_types')
                ->onDelete('restrict');
            $table->foreignId('marital_status_id')
                ->references('id')
                ->on('marital_statuses')
                ->onDelete('restrict');
            $table->date('join_date');
            $table->string('gender');
            $table->string('religion')
                ->nullable();
            $table->date('leaving_date')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
