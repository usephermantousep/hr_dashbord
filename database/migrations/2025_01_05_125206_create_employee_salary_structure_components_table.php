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
        Schema::create('employee_salary_structure_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_salary_structure_id');
            $table->foreign('employee_salary_structure_id', 'emp_sal_str_id')
                ->references('id')
                ->on('employee_salary_structures')
                ->onDelete('restrict');
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
        Schema::dropIfExists('employee_salary_structure_components');
    }
};
