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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('title');

            $table->string('slug')->unique();

            $table->text('short_description')->nullable();

            $table->longText('description')->nullable();

            $table->integer('duration_days')->default(0);

            $table->integer('duration_nights')->default(0);

            $table->decimal('starting_price', 10, 2)->nullable();

            $table->string('thumbnail')->nullable();

            $table->boolean('featured')->default(false);

            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
