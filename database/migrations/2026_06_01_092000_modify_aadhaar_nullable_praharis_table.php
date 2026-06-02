<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('praharis', 'aadhaar_number')) {
            return;
        }
    }

    public function down(): void
    {
        //
    }
};
