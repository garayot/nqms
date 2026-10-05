<?php

namespace Tests\Feature;

use App\Enums\DocumentStatus;
use App\Enums\UserRole;
use App\Models\DocumentType;
use App\Models\FormTemplate;
use App\Models\NqmsManual;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicFileAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_google_login_before_downloading_a_form_template(): void
    {
        $documentType = DocumentType::create([
            'name' => 'Form/Template',
            'description' => 'Standardized forms and templates.',
            'is_active' => true,
        ]);

        $formTemplate = FormTemplate::create([
            'document_type_id' => $documentType->id,
            'document_reference_code' => 'FT-LOGIN-001',
            'doc_title' => 'Restricted Template',
            'responsible' => 'QMS Unit',
            'status' => DocumentStatus::ACTIVE->value,
            'downloadable_attachment_path' => 'https://example.com/restricted-template.pdf',
        ]);

        $response = $this->get(route('public.file-access.form-templates', $formTemplate));

        $response->assertRedirect(route('login.google'));
    }

    public function test_authenticated_user_can_access_nqms_manual_download_route(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $documentType = DocumentType::create([
            'name' => 'Manual',
            'description' => 'Manual documents.',
            'is_active' => true,
        ]);

        $manual = NqmsManual::create([
            'document_type_id' => $documentType->id,
            'document_reference_code' => 'NM-001',
            'doc_title' => 'NQMS Manual',
            'responsible' => 'QMS Unit',
            'created_by' => $admin->id,
            'status' => DocumentStatus::ACTIVE->value,
            'downloadable_attachment_url' => 'https://example.com/nqms-manual.pdf',
        ]);

        $response = $this->actingAs($admin)->get(route('public.file-access.nqms-manuals', $manual));

        $response->assertRedirect('https://example.com/nqms-manual.pdf');
    }

    public function test_forms_repository_shows_active_and_obsolete_documents_when_all_status_is_selected(): void
    {
        $documentType = DocumentType::create([
            'name' => 'Form/Template',
            'description' => 'Standardized forms and templates.',
            'is_active' => true,
        ]);

        FormTemplate::create([
            'document_type_id' => $documentType->id,
            'document_reference_code' => 'FT-ACTIVE-001',
            'doc_title' => 'Active Template',
            'responsible' => 'QMS Unit',
            'status' => DocumentStatus::ACTIVE->value,
        ]);

        FormTemplate::create([
            'document_type_id' => $documentType->id,
            'document_reference_code' => 'FT-OBSOLETE-001',
            'doc_title' => 'Obsolete Template',
            'responsible' => 'QMS Unit',
            'status' => DocumentStatus::OBSOLETE->value,
        ]);

        $this->get(route('forms.index', ['status' => '']))
            ->assertOk()
            ->assertSee('Active Template')
            ->assertSee('Obsolete Template');
    }

    public function test_nqms_manual_repository_shows_active_and_obsolete_documents_when_all_status_is_selected(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $documentType = DocumentType::create([
            'name' => 'Manual',
            'description' => 'Manual documents.',
            'is_active' => true,
        ]);

        NqmsManual::create([
            'document_type_id' => $documentType->id,
            'document_reference_code' => 'NM-ACTIVE-001',
            'doc_title' => 'Active Manual',
            'responsible' => 'QMS Unit',
            'created_by' => $admin->id,
            'status' => DocumentStatus::ACTIVE->value,
        ]);

        NqmsManual::create([
            'document_type_id' => $documentType->id,
            'document_reference_code' => 'NM-OBSOLETE-001',
            'doc_title' => 'Obsolete Manual',
            'responsible' => 'QMS Unit',
            'created_by' => $admin->id,
            'status' => DocumentStatus::OBSOLETE->value,
        ]);

        $this->get(route('nqms-manuals.index', ['status' => '']))
            ->assertOk()
            ->assertSee('Active Manual')
            ->assertSee('Obsolete Manual');
    }
}
