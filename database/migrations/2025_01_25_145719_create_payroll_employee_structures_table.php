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
        Schema::create('payroll_employee_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_employee_id')
                ->references('id')
                ->on('payroll_employees')
                ->onDelete('cascade');
            $table->foreignId('salary_component_id')
                ->references('id')
                ->on('salary_components')
                ->onDelete('restrict');
            $table->double('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_employee_structures');
    }
};
