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
        Schema::create('technologies_job_posts', function (Blueprint $table) {
            $table->foreignId('job_post_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('technology_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            // Define the composite primary key
            $table->primary(['technology_id', 'job_post_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technologies_job_posts');
    }
};
