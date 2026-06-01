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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prahari_id')->constrained('praharis')->onDelete('cascade');
        $table->foreignId('challan_id')->nullable()->constrained('challans')->onDelete('set null');
        $table->enum('type', ['credit', 'debit']);
        $table->decimal('amount', 10, 2);
        $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
