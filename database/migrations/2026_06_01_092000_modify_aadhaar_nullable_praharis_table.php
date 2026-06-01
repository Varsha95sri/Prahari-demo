<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure aadhaar_number column is nullable
        DB::statement("ALTER TABLE `praharis` MODIFY `aadhaar_number` varchar(255) NULL");
    }

    public function down(): void
    {
        // revert to NOT NULL without default (may fail if data exists) - skip reversing
        if (Schema::hasColumn('praharis', 'aadhaar_number')) {
            // do nothing on down to avoid accidental data loss
        }
    }
};
