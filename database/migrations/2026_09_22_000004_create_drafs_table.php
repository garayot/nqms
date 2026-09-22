<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drafs', function (Blueprint $table) {
            $table->id();
            $table->string('draf_number')->index();
            $table->string('source');
            $table->string('request_for');
            $table->foreignId('doc_type_id')->constrained('document_types')->cascadeOnUpdate();
            $table->string('applicability');
            $table->string('title');
            $table->string('reference_code')->nullable()->index();
            $table->string('current_revision_no');
            $table->text('reason')->nullable();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('date_requested');
            $table->string('attachment_path')->nullable();
            $table->string('status')->default('draft')->index();
            $table->string('review')->nullable();
            $table->text('reason1')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->string('approval')->nullable();
            $table->text('reason2')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->string('new_revision_number')->nullable();
            $table->date('effectivity_date')->nullable();
            $table->date('date_registered')->nullable();
            $table->string('approved_attachment_path')->nullable();
            $table->timestamps();
            $table->index('doc_type_id');
            $table->index('applicability');
            $table->index('requested_by');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drafs');
    }
};
