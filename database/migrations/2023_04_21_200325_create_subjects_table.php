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
        Schema::create('subjects', function (Blueprint $table) {
            $table->string('code')->primary()->unique();
            $table->string('title');
            $table->string('description')->nullable();
            $table->integer('units');
            $table->integer('hours');

            $table->string('prerequisite_code')->nullable();
            $table->string('corequisite_code')->nullable();

            $table->string('syllabus')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            $table->index('code');
        });

        Schema::table('subjects',function (Blueprint $table){
            $table->foreign('prerequisite_code')->references('code')->on('subjects')->onDelete('cascade');
            $table->foreign('corequisite_code')->references('code')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
