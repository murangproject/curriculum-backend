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
        Schema::create('curriculum_subjects', function (Blueprint $table) {
            $table->unsignedBigInteger('curriculum_id');
            $table->string('subject_code');
            $table->timestamps();

            $table->foreign('curriculum_id')->references('id')->on('curricula')->onDelete('cascade');
            $table->foreign('subject_code')->references('code')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculum_subject');
    }
};
