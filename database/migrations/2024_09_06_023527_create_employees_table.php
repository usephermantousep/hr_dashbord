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
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')
                ->references('id')
                ->on('branches')
                ->onDelete('restrict');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('restrict');
            $table->unsignedBigInteger('job_position_id');
            $table->foreign('job_position_id')
                ->references('id')
                ->on('job_positions')
                ->onDelete('restrict');
            $table->string('status');
            $table->date('join_date');
            $table->string('gender');
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
