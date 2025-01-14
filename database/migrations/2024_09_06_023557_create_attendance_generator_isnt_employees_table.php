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
        Schema::create('attendance_generator_isnt_employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->date('date');
            $table->string('mechine_id');
            $table->unsignedBigInteger('attendance_generator_id');
            $table->foreign('attendance_generator_id', 'att_gen_id')
                ->references('id')
                ->on('attendance_generators')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_generator_isnt_employees');
    }
};
