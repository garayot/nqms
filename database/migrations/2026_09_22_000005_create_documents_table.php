<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draf_id')->constrained('drafs')->cascadeOnDelete();
            $table->foreignId('originating_office_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('location')->nullable();
            $table->string('status')->default('active')->index();
            $table->string('downloadable_doc_path')->nullable();
            $table->timestamps();
            $table->index('draf_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
