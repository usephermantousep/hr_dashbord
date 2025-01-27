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
        Schema::create('payroll_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')
                ->references('id')
                ->on('payrolls')
                ->onDelete('cascade');
            $table->foreignId('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('restrict');
            $table->foreignId('employee_salary_structure_id')
                ->references('id')
                ->on('employee_salary_structures')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_employees');
    }
};
