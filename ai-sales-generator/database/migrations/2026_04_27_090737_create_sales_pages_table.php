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
        Schema::create('sales_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // === INPUT FIELDS ===
            $table->string('product_name');
            $table->text('description');
            $table->text('features')->nullable();
            $table->string('target_audience')->nullable();
            $table->string('price')->nullable();
            $table->text('usp')->nullable();
            $table->string('tone')->default('professional');
            $table->string('template')->default('default');

            // === GENERATED CONTENT ===
            $table->string('headline')->nullable();
            $table->string('subheadline')->nullable();
            $table->text('product_description')->nullable();
            $table->json('benefits')->nullable();
            $table->json('features_breakdown')->nullable();
            $table->json('testimonials')->nullable();
            $table->string('cta_text')->nullable();
            $table->string('cta_button')->nullable();
            $table->string('pricing_label')->nullable();
            $table->json('raw_generated')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_pages');
    }
};
