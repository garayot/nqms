<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('process_groups', function (Blueprint $table) {
            $table->id();
            $table->string('process_group_name');
            $table->timestamps();

            $table->index('process_group_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('process_groups');
    }
};
