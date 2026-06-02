<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('praharis', function (Blueprint $table) {
            if (! Schema::hasColumn('praharis', 'record_date')) {
                $table->date('record_date')->nullable();
            }

            if (! Schema::hasColumn('praharis', 'image_path')) {
                $table->string('image_path')->nullable();
            }

            if (! Schema::hasColumn('praharis', 'video_path')) {
                $table->string('video_path')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('praharis', function (Blueprint $table) {
            foreach (['video_path', 'image_path', 'record_date'] as $column) {
                if (Schema::hasColumn('praharis', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
