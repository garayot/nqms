<?php

namespace Tests\Feature;

use App\Enums\DocumentStatus;
use App\Enums\DrafApplicability;
use App\Enums\DrafRequestType;
use App\Enums\DrafSource;
use App\Enums\UserRole;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Draf;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_document_download(): void
    {
        Storage::fake('local');

        $document = $this->createDocumentWithAttachment();

        $this->get(route('documents.download', $document))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_download_document(): void
    {
        Storage::fake('local');

        /** @var User $user */
        $user = User::factory()->create([
            'role' => UserRole::USER,
        ]);

        $document = $this->createDocumentWithAttachment();

        $response = $this->actingAs($user)->get(route('documents.download', $document));

        $response->assertOk();
        $this->assertStringContainsString('attachment.pdf', (string) $response->headers->get('content-disposition'));
    }

    private function createDocumentWithAttachment(): Document
    {
        $requester = User::factory()->create([
            'office' => 'Records Office',
        ]);

        $documentType = DocumentType::create([
            'name' => 'Registered Document',
            'description' => 'Approved and registered documents.',
            'is_active' => true,
        ]);

        $draf = Draf::create([
            'draf_number' => 'DRAF-1001',
            'source' => DrafSource::INTERNAL->value,
            'request_for' => DrafRequestType::CREATION->value,
            'doc_type_id' => $documentType->id,
            'applicability' => DrafApplicability::SDO->value,
            'title' => 'Security Memo',
            'reference_code' => 'SEC-001',
            'current_revision_no' => '01',
            'reason' => 'Test fixture',
            'requested_by' => $requester->id,
            'date_requested' => '2026-09-29',
            'status' => 'registered',
            'new_revision_number' => '01',
            'effectivity_date' => '2026-09-29',
            'date_registered' => '2026-09-29',
            'approved_attachment_path' => 'documents/final/attachment.pdf',
        ]);

        Storage::disk('local')->put('documents/final/attachment.pdf', 'document contents');

        return Document::create([
            'draf_id' => $draf->id,
            'originating_office_id' => $requester->id,
            'location' => 'Records Office',
            'status' => DocumentStatus::ACTIVE->value,
            'downloadable_doc_path' => 'documents/final/attachment.pdf',
        ]);
    }
}
