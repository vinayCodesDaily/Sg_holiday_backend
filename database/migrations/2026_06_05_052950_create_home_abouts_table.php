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
        Schema::create('home_about', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->longText('description');

            $table->string('image')->nullable();

            $table->string('plan_trip_button_text')
                ->default('Plan A Trip');

            $table->string('plan_trip_button_link')
                ->nullable();

            $table->string('whatsapp_button_text')
                ->default('Chat On WhatsApp');

            $table->string('whatsapp_number')
                ->nullable();

            $table->boolean('status')
                ->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_abouts');
    }
};
