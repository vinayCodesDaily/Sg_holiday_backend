<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->text('transportation')->nullable()->after('description');
            $table->text('accommodation')->nullable()->after('transportation');
            $table->text('best_season')->nullable()->after('accommodation');
            $table->text('meals')->nullable()->after('best_season');
            $table->text('main_attractions')->nullable()->after('meals');
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'transportation',
                'accommodation',
                'best_season',
                'meals',
                'main_attractions',
            ]);
        });
    }
};
