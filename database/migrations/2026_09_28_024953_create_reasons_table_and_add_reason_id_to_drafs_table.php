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
        Schema::create('reasons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::table('drafs', function (Blueprint $table) {
            $table->foreignId('reason_id')
                ->nullable()
                ->after('current_revision_no')
                ->constrained('reasons')
                ->nullOnDelete();
            $table->index('reason_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drafs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reason_id');
        });

        Schema::dropIfExists('reasons');
    }
};
