<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->string('destination')->nullable()->after('phone');
            $table->date('travel_date')->nullable()->after('destination');
            $table->unsignedInteger('number_of_persons')->nullable()->after('travel_date');
        });
    }

    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropColumn(['destination', 'travel_date', 'number_of_persons']);
        });
    }
};
