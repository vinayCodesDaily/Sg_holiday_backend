<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE enquiries
            MODIFY COLUMN status
            ENUM(
                'new',
                'in_progress',
                'contacted',
                'resolved',
                'closed'
            )
            DEFAULT 'new'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE enquiries
            MODIFY COLUMN status
            ENUM(
                'new',
                'contacted',
                'closed'
            )
            DEFAULT 'new'
        ");
    }
};