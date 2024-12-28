<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('prefix');
            $table->string('year_month');
            $table->integer('sequence');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_numbers');
    }
};
