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
        Schema::create('monthly_destinations', function (Blueprint $table) {

            $table->id();

            $table->string('month');

            $table->string('place_name');

            $table->text('description');

            $table->foreignId('package_id')
                ->nullable()
                ->constrained('packages')
                ->nullOnDelete();

            $table->integer('display_order')->default(0);

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_destinations');
    }
};
