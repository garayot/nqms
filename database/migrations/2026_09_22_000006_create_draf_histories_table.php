<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('draf_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draf_id')->constrained('drafs')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index('draf_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('draf_histories');
    }
};
