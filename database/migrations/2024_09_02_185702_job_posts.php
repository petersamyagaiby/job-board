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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->enum('status', ["pending", "approved", "rejected"])->default("pending");

            $table->boolean('is_active')->default(true);
            $table->text('description');
            $table->float('min_salary');
            $table->float('max_salary');
            $table->text('qualifications');
            $table->text('responsibilities');
            $table->text('benefits');
            $table->enum('work_type', ["onsite", "remote", "hybrid", "freelance"]);
            $table->date('deadline');
            $table->tinyInteger('vacancies');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
