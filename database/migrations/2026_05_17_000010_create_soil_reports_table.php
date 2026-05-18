<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soil_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('image_path')->nullable();
            $table->string('title')->default('Soil Analysis Report');

            // Nutrient inputs
            $table->float('ph_level')->nullable();
            $table->float('nitrogen')->nullable();
            $table->float('phosphorus')->nullable();
            $table->float('potassium')->nullable();
            $table->float('moisture')->nullable();
            $table->float('organic_matter')->nullable();

            // Rule-based analysis results
            $table->string('soil_type')->nullable();
            $table->string('soil_ph_category')->nullable(); // acidic / neutral / alkaline
            $table->integer('health_score')->nullable();
            $table->string('health_status')->nullable(); // Healthy / Moderate / Poor
            $table->text('soil_condition')->nullable();
            $table->json('deficiencies')->nullable();
            $table->json('fertilizer_recommendations')->nullable();
            $table->json('crop_recommendations')->nullable();

            // AI (Gemini Vision) analysis
            $table->text('ai_analysis')->nullable();
            $table->text('ai_soil_type')->nullable();
            $table->text('ai_recommendations')->nullable();

            // Weather (stub)
            $table->string('location')->nullable();
            $table->float('temperature')->nullable();
            $table->string('weather_desc')->nullable();

            $table->string('status')->default('pending'); // pending / analyzed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soil_reports');
    }
};
