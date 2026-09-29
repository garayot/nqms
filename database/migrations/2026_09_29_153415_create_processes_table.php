<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->string('process_name');
            $table->foreignId('process_group_id')->constrained('process_groups')->cascadeOnDelete();
            $table->timestamps();

            $table->index('process_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};
