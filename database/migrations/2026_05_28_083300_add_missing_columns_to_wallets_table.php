<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            if (! Schema::hasColumn('wallets', 'prahari_id')) {
                $table->foreignId('prahari_id')->nullable()->after('id')->constrained('praharis')->onDelete('cascade');
            }

            if (! Schema::hasColumn('wallets', 'balance')) {
                $table->decimal('balance', 10, 2)->default(0)->after('prahari_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            if (Schema::hasColumn('wallets', 'prahari_id')) {
                $table->dropConstrainedForeignId('prahari_id');
            }

            if (Schema::hasColumn('wallets', 'balance')) {
                $table->dropColumn('balance');
            }
        });
    }
};
