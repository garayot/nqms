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
        Schema::create('nqms_manuals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_type_id')->constrained('document_types')->cascadeOnUpdate();
            $table->string('document_reference_code')->unique();
            $table->string('doc_title');
            $table->string('responsible');
            $table->string('revision_number')->nullable();
            $table->date('effectivity_date')->nullable();
            $table->string('document_location')->nullable();
            $table->string('status')->default('active')->index();
            $table->string('downloadable_attachment_url')->nullable();
            $table->timestamps();

            $table->index('document_type_id');
            $table->index('effectivity_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nqms_manuals');
    }
};
