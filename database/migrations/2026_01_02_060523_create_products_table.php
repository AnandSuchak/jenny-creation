<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            // 🔗 Relationship: Product → Category
            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // Core fields
            $table->string('name');

            // Slug optional but unique if present
            $table->string('slug')->nullable()->unique();

            // Auto-generated SKU (required + unique)
            $table->string('sku')->unique();

            // Single image for now
            $table->string('image')->nullable();

            // Optional description
            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Index for faster queries
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
