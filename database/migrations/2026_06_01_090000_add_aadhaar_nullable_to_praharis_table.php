<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // Use raw SQL with IF NOT EXISTS so it's safe on existing databases
        DB::statement("ALTER TABLE `praharis` ADD COLUMN IF NOT EXISTS `aadhaar_number` varchar(255) NULL AFTER `phone`");
    }

    public function down(): void
    {
        if (Schema::hasColumn('praharis', 'aadhaar_number')) {
            Schema::table('praharis', function (Blueprint $table) {
                $table->dropColumn('aadhaar_number');
            });
        }
    }
};
