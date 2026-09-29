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
        Schema::create('form_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_type_id')->constrained('document_types')->restrictOnDelete();
            $table->string('document_reference_code')->unique();
            $table->string('doc_title');
            $table->string('responsible');
            $table->string('revision_number')->nullable();
            $table->date('effectivity_date')->nullable();
            $table->string('document_location')->nullable();
            $table->string('status')->default('active')->index();
            $table->string('downloadable_attachment_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_templates');
    }
};
