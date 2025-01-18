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
        Schema::create('employee_salary_structures', function (Blueprint $table) {
            $table->id();
            $table->string('document_number');
            $table->foreignId('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('restrict');
            $table->foreignId('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            $table->foreignId('updated_by')
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
        Schema::dropIfExists('employee_salary_structures');
    }
};
