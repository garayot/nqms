<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('process_groups', function (Blueprint $table) {
            $table->string('url')->nullable()->after('process_group_name');
        });
    }

    public function down(): void
    {
        Schema::table('process_groups', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
};
