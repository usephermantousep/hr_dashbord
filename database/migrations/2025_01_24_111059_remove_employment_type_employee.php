<?php

use App\Models\EmploymentType;
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
            $table->dropForeignIdFor(EmploymentType::class, 'employment_type_id');
            $table->dropColumn('employment_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('employment_type_id')
                ->nullable()
                ->references('id')
                ->on('employment_types')
                ->onDelete('restrict');
        });
    }
};
