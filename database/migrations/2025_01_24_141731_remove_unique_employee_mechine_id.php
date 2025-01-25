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
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasIndex('employees', 'employees_employee_mechine_id_unique')) {
                $table->dropIndex('employees_employee_mechine_id_unique');
            }
            $table->string('employee_mechine_id')
                ->nullable()
                ->change();
            $table->unique([
                'branch_id',
                'employee_mechine_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropUnique([
                'branch_id',
                'employee_mechine_id',
            ]);
            $table->string('employee_mechine_id')
                ->nullable()
                ->change();
        });
    }
};
