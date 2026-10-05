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
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('attribute', ['benefit', 'cost'])->default('benefit');
            $table->decimal('weight', 8, 4)->default(0);
            $table->string('unit')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('criteria_scales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            $table->string('label');
            $table->decimal('value', 8, 2);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('alternatives', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->text('spec_summary')->nullable();
            $table->decimal('price_raw', 15, 2)->nullable();
            $table->string('image_url')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('alternative_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->constrained('alternatives')->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            $table->decimal('score', 10, 4)->default(0);
            $table->timestamps();
            $table->unique(['alternative_id', 'criteria_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternative_scores');
        Schema::dropIfExists('alternatives');
        Schema::dropIfExists('criteria_scales');
        Schema::dropIfExists('criterias');
    }
};
