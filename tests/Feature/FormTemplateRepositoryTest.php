<?php

namespace Tests\Feature;

use App\Enums\DocumentStatus;
use App\Enums\UserRole;
use App\Models\DocumentType;
use App\Models\FormTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FormTemplateRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_form_template_and_public_repository_shows_it(): void
    {
        Storage::fake('public');

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
            'downloadable_attachment' => UploadedFile::fake()->create('template.pdf', 100, 'application/pdf'),
        ]);

        $response->assertRedirect();

        $template = FormTemplate::query()->firstOrFail();

        $this->assertTrue(Storage::disk('public')->exists($template->downloadable_attachment_path));

        $this->get(route('forms.index'))
            ->assertOk()
            ->assertSee('Quality Control Plan Template')
            ->assertSee('Form/Template')
            ->assertSee('FT-001');
    }
}
