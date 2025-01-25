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
        Schema::table('payrolls', function (Blueprint $table) {
            if (Schema::hasIndex('payrolls', 'payrolls_employee_id_foreign')) {
                $table->dropForeign('payrolls_employee_id_foreign');
            }
            $table->dropColumn('employee_id');
            $table->dropColumn('period');
            $table->foreignId('branch_id')
                ->after('id')
                ->references('id')
                ->on('branches')
                ->onDelete('restrict');
            $table->integer('month')
                ->after('branch_id');
            $table->integer('year')
                ->after('month');
            $table->float('total')
                ->after('year')
                ->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            if (Schema::hasIndex('payrolls', 'payrolls_branch_id_foreign')) {
                $table->dropForeign('payrolls_branch_id_foreign');
            }
            $table->dropColumn('branch_id');
            $table->dropColumn('month');
            $table->dropColumn('year');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('restrict');
            $table->date('period');
        });
    }
};
