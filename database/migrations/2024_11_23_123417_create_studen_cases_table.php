<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('studen_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->string('case');
            $table->string('type');
            $table->integer('point');
            $table->string('status');
            $table->text('solution')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studen_cases');
    }
};
