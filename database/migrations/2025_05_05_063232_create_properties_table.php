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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->enum('type', ['rent', 'sale']);
            $table->bigInteger('price');
            $table->string('location');
            $table->foreignId('region_id')->nullable()->constrained('regions')->nullOnDelete();
            $table->enum('status', ['available', 'pending', 'sold'])->default('available');
            $table->string('featured_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
