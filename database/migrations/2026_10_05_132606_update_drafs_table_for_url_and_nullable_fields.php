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
        Schema::table('drafs', function (Blueprint $table) {
            $table->string('draf_number')->nullable()->change();
            $table->text('open_ended_reason')->nullable()->after('reason');
        });

        Schema::table('drafs', function (Blueprint $table) {
            $table->renameColumn('attachment_path', 'attachment_url');
        });

        Schema::table('drafs', function (Blueprint $table) {
            $table->renameColumn('approved_attachment_path', 'approved_attachment_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drafs', function (Blueprint $table) {
            $table->renameColumn('attachment_url', 'attachment_path');
        });

        Schema::table('drafs', function (Blueprint $table) {
            $table->renameColumn('approved_attachment_url', 'approved_attachment_path');
        });

        Schema::table('drafs', function (Blueprint $table) {
            $table->dropColumn('open_ended_reason');
            $table->string('draf_number')->change();
        });
    }
};
