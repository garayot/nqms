<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Position;
use App\Models\Team;
use App\Models\TeamLead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QmsTeamsModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_organization_page_lists_teams(): void
    {
        Team::create([
            'team_name' => 'Knowledge Management Team',
            'abbreviation' => 'KMT',
        ]);

        $this->get(route('organization'))
            ->assertOk()
            ->assertSee('Knowledge Management Team')
            ->assertSee('KMT')
            ->assertSee('View Organization Chart');
    }

    public function test_non_admin_cannot_access_admin_team_management(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'role' => UserRole::USER,
        ]);

        $this->actingAs($user)
            ->get(route('admin.qms-teams.index'))
            ->assertForbidden();
    }

    public function test_admin_can_create_positions_and_update_user_position(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.positions.store'), [
                'position_name' => 'PDO I',
            ])
            ->assertRedirect(route('admin.positions.index'));

        $position = Position::query()->where('position_name', 'PDO I')->firstOrFail();

        $user = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.users.role', $user), [
                'role' => UserRole::REVIEWER->value,
                'position_id' => $position->id,
            ])
            ->assertRedirect();

        $user->refresh();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => UserRole::REVIEWER->value,
            'position_id' => $position->id,
        ]);
    }

    public function test_admin_can_manage_team_assignments_without_duplicate_rows(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $leadPosition = Position::create(['position_name' => 'PDO I']);
        $memberPosition = Position::create(['position_name' => 'AO II']);
        $secretariatPosition = Position::create(['position_name' => 'ENGINEER IV']);

        $team = Team::create([
            'team_name' => 'Knowledge Management Team',
            'abbreviation' => 'KMT',
        ]);

        $lead = User::factory()->create([
            'name' => 'Peter Ville C. Carmen',
            'position_id' => $leadPosition->id,
        ]);

        $member = User::factory()->create([
            'name' => 'Joel Miller M. Go',
            'position_id' => $memberPosition->id,
        ]);

        $secretariat = User::factory()->create([
            'name' => 'Paul Vincent L. Garay',
            'position_id' => $secretariatPosition->id,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.qms-teams.leads.store', $team), [
                'team_id' => $team->id,
                'user_id' => $lead->id,
            ])
            ->assertRedirect();

        $this->actingAs($admin)
            ->post(route('admin.qms-teams.leads.store', $team), [
                'team_id' => $team->id,
                'user_id' => $lead->id,
            ])
            ->assertRedirect();

        $this->actingAs($admin)
            ->post(route('admin.qms-teams.members.store', $team), [
                'team_id' => $team->id,
                'user_id' => $member->id,
            ])
            ->assertRedirect();

        $this->actingAs($admin)
            ->post(route('admin.qms-teams.secretariat.store', $team), [
                'team_id' => $team->id,
                'user_id' => $secretariat->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseCount('team_leads', 1);
        $this->assertDatabaseHas('team_leads', [
            'team_id' => $team->id,
            'user_id' => $lead->id,
        ]);
        $this->assertDatabaseHas('team_members', [
            'team_id' => $team->id,
            'user_id' => $member->id,
        ]);
        $this->assertDatabaseHas('team_secretariats', [
            'team_id' => $team->id,
            'user_id' => $secretariat->id,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.qms-teams.show', $team))
            ->assertOk()
            ->assertSee('Knowledge Management Team')
            ->assertSee('KMT Lead')
            ->assertSee('KMT Member')
            ->assertSee('KMT Secretariat')
            ->assertSee('Peter Ville C. Carmen')
            ->assertSee('Joel Miller M. Go')
            ->assertSee('Paul Vincent L. Garay');

        /** @var TeamLead $teamLead */
        $teamLead = TeamLead::query()->firstOrFail();

        $this->actingAs($admin)
            ->delete(route('admin.qms-teams.leads.destroy', [$team, $teamLead]))
            ->assertRedirect();

        $this->assertDatabaseMissing('team_leads', [
            'id' => $teamLead->id,
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $lead->id,
        ]);

        $this->assertDatabaseCount('team_members', 1);
        $this->assertDatabaseCount('team_secretariats', 1);
    }
}
