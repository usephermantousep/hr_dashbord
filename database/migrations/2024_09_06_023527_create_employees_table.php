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
            $table->string('employee_mechine_id')
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
            $table->date('start_contract')
                ->nullable();
            $table->date('end_contract')
                ->nullable();
            $table->foreignId('employment_type_id')
                ->references('id')
                ->on('employment_types')
                ->onDelete('restrict');
            $table->foreignId('marital_status_id')
                ->references('id')
                ->on('marital_statuses')
                ->onDelete('restrict');
            $table->date('join_date');
            $table->date('leaving_date')
                ->nullable();
            $table->string('gender');
            $table->string('religion')
                ->nullable();
            $table->string('place_of_birth')
                ->nullable();
            $table->date('date_of_birth')
                ->nullable();
            $table->string('last_education')
                ->nullable();
            $table->string('last_education_major')
                ->nullable();
            $table->string('identity_no')
                ->nullable();
            $table->string('npwp_no')
                ->nullable();
            $table->string('health_bpjs')
                ->nullable();
            $table->string('employment_bpjs')
                ->nullable();
            $table->string('phone_number')
                ->nullable();
            $table->foreignId('salary_structure_id')
                ->nullable()
                ->references('id')
                ->on('salary_structures')
                ->onDelete('restrict');
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
