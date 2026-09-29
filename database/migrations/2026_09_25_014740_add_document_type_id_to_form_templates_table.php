<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('form_templates', 'document_type_id')) {
            Schema::table('form_templates', function (Blueprint $table): void {
                $table->foreignId('document_type_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('document_types')
                    ->nullOnDelete();
            });

            DB::table('form_templates')
                ->orderBy('id')
                ->get(['id', 'document_reference_code'])
                ->each(function ($template): void {
                    $documentTypeId = DB::table('drafs')
                        ->where('reference_code', $template->document_reference_code)
                        ->value('doc_type_id');

                    if ($documentTypeId) {
                        DB::table('form_templates')
                            ->where('id', $template->id)
                            ->update(['document_type_id' => $documentTypeId]);
                    }
                });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('form_templates', 'document_type_id')) {
            Schema::table('form_templates', function (Blueprint $table): void {
                $table->dropConstrainedForeignId('document_type_id');
            });
        }
    }
};
