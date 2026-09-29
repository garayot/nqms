<?php

namespace Tests\Feature;

use App\Enums\DrafApplicability;
use App\Enums\DrafRequestType;
use App\Enums\DrafSource;
use App\Enums\UserRole;
use App\Models\DocumentType;
use App\Models\Draf;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewerRoleFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_reviewer_can_access_the_review_drafs_page(): void
    {
        /** @var User $reviewer */
        $reviewer = User::factory()->create([
            'role' => UserRole::REVIEWER,
        ]);

        $documentType = DocumentType::create([
            'name' => 'Policy',
            'description' => 'Policy document type',
            'is_active' => true,
        ]);

        Draf::create([
            'draf_number' => 'DRAF-1001',
            'source' => DrafSource::INTERNAL->value,
            'request_for' => DrafRequestType::CREATION->value,
            'doc_type_id' => $documentType->id,
            'applicability' => DrafApplicability::SDO->value,
            'title' => 'Sample Review DRAF',
            'current_revision_no' => '01',
            'requested_by' => $reviewer->id,
            'date_requested' => '2026-09-29',
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($reviewer)->get(route('reviewer.drafs.index'));

        $response->assertOk();
        $response->assertSee('Review DRAFs');
        $response->assertSee('DRAF-1001');
    }

    public function test_admin_can_access_both_review_and_approval_queues(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->actingAs($admin)
            ->get(route('reviewer.drafs.index'))
            ->assertOk()
            ->assertSee('Review DRAFs');

        $this->actingAs($admin)
            ->get(route('approver.drafs.index'))
            ->assertOk()
            ->assertSee('Approver Queue');
    }

    public function test_admin_can_manage_users_as_reviewer_role(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        /** @var User $target */
        $target = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Reviewer')
            ->assertSee('Approver');

        $this->actingAs($admin)
            ->post(route('admin.users.role', $target), [
                'role' => UserRole::REVIEWER->value,
            ])
            ->assertRedirect();

        $target->refresh();

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'role' => UserRole::REVIEWER->value,
        ]);
    }
}
