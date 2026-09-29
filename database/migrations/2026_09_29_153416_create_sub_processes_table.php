<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_processes', function (Blueprint $table) {
            $table->id();
            $table->string('sub_process_name');
            $table->string('url', 2048)->nullable();
            $table->foreignId('process_id')->constrained('processes')->cascadeOnDelete();
            $table->timestamps();

            $table->index('sub_process_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_processes');
    }
};
