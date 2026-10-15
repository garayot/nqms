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
        Schema::create('qms_organization_members', function (Blueprint $table): void {
            $table->id();
            $table->string('role', 50);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('display_order')->default(1);
            $table->timestamps();

            $table->unique(['role', 'user_id']);
            $table->index(['role', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qms_organization_members');
    }
};
