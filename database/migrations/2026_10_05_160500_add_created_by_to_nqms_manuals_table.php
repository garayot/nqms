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
        Schema::table('nqms_manuals', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->after('responsible')
                ->constrained('users')
                ->nullOnDelete();

            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nqms_manuals', function (Blueprint $table) {
            $table->dropIndex(['created_by']);
            $table->dropConstrainedForeignId('created_by');
        });
    }
};
