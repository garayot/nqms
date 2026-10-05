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
use App\Models\FormTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FormTemplateRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_download_csv_template_for_bulk_import(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.form-templates.csv-template'));

        $response->assertOk();
        $this->assertStringContainsString('form-templates-import-template.csv', (string) $response->headers->get('content-disposition'));
        $this->assertStringContainsString('text/csv', (string) $response->headers->get('content-type'));
        $this->assertStringContainsString('document_type,document_reference_code,doc_title,responsible', $response->streamedContent());
    }

    public function test_admin_can_create_a_form_template_using_attachment_url(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $documentType = DocumentType::create([
            'name' => 'QMS Manual',
            'description' => 'Quality Management System manual documents.',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.form-templates.store'), [
            'document_type_id' => $documentType->id,
            'document_reference_code' => 'URL-001',
            'doc_title' => 'Public Manual',
            'responsible' => 'QMS Unit',
            'revision_number' => '02',
            'effectivity_date' => '2026-09-25',
            'document_location' => 'Portal',
            'status' => DocumentStatus::ACTIVE->value,
            'downloadable_attachment_url' => 'https://example.com/manual.pdf',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('form_templates', [
            'document_reference_code' => 'URL-001',
            'downloadable_attachment_path' => 'https://example.com/manual.pdf',
        ]);
    }

    public function test_admin_can_create_a_form_template_and_public_repository_shows_it(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $documentType = DocumentType::create([
            'name' => 'Form/Template',
            'description' => 'Standardized forms and templates.',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.form-templates.store'), [
            'document_type_id' => $documentType->id,
            'document_reference_code' => 'FT-001',
            'doc_title' => 'Quality Control Plan Template',
            'responsible' => 'Quality Team',
            'revision_number' => '01',
            'effectivity_date' => '2026-09-25',
            'document_location' => 'Records Room',
            'status' => DocumentStatus::ACTIVE->value,
            'downloadable_attachment_url' => 'https://example.com/template.pdf',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('form_templates', [
            'document_reference_code' => 'FT-001',
            'downloadable_attachment_path' => 'https://example.com/template.pdf',
        ]);

        $this->get(route('forms.index'))
            ->assertOk()
            ->assertSee('Quality Control Plan Template')
            ->assertSee('Form/Template')
            ->assertSee('FT-001');
    }

    public function test_authenticated_user_can_open_forms_print_preview_with_selected_document_type(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $documentType = DocumentType::create([
            'name' => 'Form/Template',
            'description' => 'Standardized forms and templates.',
            'is_active' => true,
        ]);

        FormTemplate::create([
            'document_type_id' => $documentType->id,
            'document_reference_code' => 'PRINT-001',
            'doc_title' => 'Printable Template',
            'responsible' => 'QMS Unit',
            'status' => DocumentStatus::ACTIVE->value,
        ]);

        $this->actingAs($admin)
            ->get(route('forms.print', ['document_type_id' => $documentType->id]))
            ->assertOk()
            ->assertSee('Document Master List')
            ->assertSee('Document Type')
            ->assertSee('Form/Template');
    }

    public function test_admin_can_import_a_registered_document_into_form_templates(): void
    {
        Storage::fake('public');

        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $requester = User::factory()->create([
            'office' => 'Curriculum Implementation Division',
        ]);

        $documentType = DocumentType::create([
            'name' => 'Form/Template',
            'description' => 'Standardized forms and templates.',
            'is_active' => true,
        ]);

        $draf = Draf::create([
            'draf_number' => 'DRAF-0001',
            'source' => DrafSource::INTERNAL->value,
            'request_for' => DrafRequestType::CREATION->value,
            'doc_type_id' => $documentType->id,
            'applicability' => DrafApplicability::SDO->value,
            'title' => 'Sample Manual Addition',
            'reference_code' => '2137',
            'current_revision_no' => '03',
            'reason' => 'Imported for repository',
            'requested_by' => $requester->id,
            'date_requested' => '2026-09-09',
            'status' => 'registered',
            'new_revision_number' => '03',
            'effectivity_date' => '2026-09-09',
            'date_registered' => '2026-09-09',
            'approved_attachment_url' => 'https://example.com/sample.pdf',
        ]);

        $document = Document::create([
            'draf_id' => $draf->id,
            'originating_office_id' => $requester->id,
            'location' => 'BCD SDO',
            'status' => DocumentStatus::ACTIVE->value,
            'downloadable_doc_path' => 'documents/final/sample.pdf',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.form-templates.import', $document))
            ->assertRedirect();

        $this->assertDatabaseHas('form_templates', [
            'document_reference_code' => '2137',
            'doc_title' => 'Sample Manual Addition',
            'responsible' => 'Curriculum Implementation Division',
            'revision_number' => '03',
            'document_location' => 'BCD SDO',
        ]);

        $this->get(route('forms.index'))
            ->assertOk()
            ->assertSee('Sample Manual Addition')
            ->assertSee('2137');

        $this->actingAs($admin)
            ->get(route('admin.form-templates.index'))
            ->assertOk()
            ->assertSee('Imported')
            ->assertSee('Already imported');
    }

    public function test_admin_form_template_page_lists_registered_documents_for_import(): void
    {
        Storage::fake('public');

        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $requester = User::factory()->create([
            'office' => 'Curriculum Implementation Division',
        ]);

        $documentType = DocumentType::create([
            'name' => 'Form/Template',
            'description' => 'Standardized forms and templates.',
            'is_active' => true,
        ]);

        $draf = Draf::create([
            'draf_number' => 'DRAF-0002',
            'source' => DrafSource::INTERNAL->value,
            'request_for' => DrafRequestType::CREATION->value,
            'doc_type_id' => $documentType->id,
            'applicability' => DrafApplicability::SDO->value,
            'title' => 'Imported Manual',
            'reference_code' => 'INV-001',
            'current_revision_no' => '01',
            'reason' => 'Seed for UI test',
            'requested_by' => $requester->id,
            'date_requested' => '2026-09-25',
            'status' => 'registered',
            'new_revision_number' => '01',
            'effectivity_date' => '2026-09-25',
            'date_registered' => '2026-09-25',
            'approved_attachment_url' => 'https://example.com/imported.pdf',
        ]);

        Document::create([
            'draf_id' => $draf->id,
            'originating_office_id' => $requester->id,
            'location' => 'BCD SDO',
            'status' => DocumentStatus::ACTIVE->value,
            'downloadable_doc_path' => 'documents/final/imported.pdf',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.form-templates.index'))
            ->assertOk()
            ->assertSee('Registered Documents')
            ->assertSee('Import to Repository');
    }

    public function test_admin_can_bulk_import_form_templates_from_csv(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        DocumentType::create([
            'name' => 'Form/Template',
            'description' => 'Standardized forms and templates.',
            'is_active' => true,
        ]);

        $csv = implode("\n", [
            'document_type,document_reference_code,doc_title,responsible,revision_number,effectivity_date,document_location,status,downloadable_attachment_url',
            'Form/Template,CSV-001,CSV Imported Template,Records Office,01,2026-09-25,Repository,active,https://example.com/csv-template.pdf',
        ]);

        $file = UploadedFile::fake()->createWithContent('form-templates.csv', $csv);

        $response = $this->actingAs($admin)->post(route('admin.form-templates.import-csv'), [
            'csv_file' => $file,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('form_templates', [
            'document_reference_code' => 'CSV-001',
            'doc_title' => 'CSV Imported Template',
            'downloadable_attachment_path' => 'https://example.com/csv-template.pdf',
        ]);
    }
}
