<?php

namespace App\Http\Controllers\Admin;

use App\Enums\QmsOrganizationRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQmsOrganizationMemberRequest;
use App\Models\QmsOrganizationMember;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class QmsOrganizationController extends Controller
{
    public function index(): View
    {
        $roleOrder = [
            QmsOrganizationRole::SDS->value => 1,
            QmsOrganizationRole::ASDS->value => 2,
            QmsOrganizationRole::QMR->value => 3,
            QmsOrganizationRole::SECRETARIAT_TEAM_LEAD->value => 4,
            QmsOrganizationRole::SECRETARIAT_TEAM_MEMBER->value => 5,
        ];

        $members = QmsOrganizationMember::query()
            ->with('user.position')
            ->get()
            ->sortBy(fn (QmsOrganizationMember $member): array => [
                $roleOrder[$member->role->value] ?? 99,
                $member->display_order,
                $member->id,
            ])
            ->values();

        $membersByRole = $members->groupBy(fn (QmsOrganizationMember $member): string => $member->role->value);

        $users = User::query()
            ->with('position')
            ->orderBy('name')
            ->get();

        return view('admin.qms-organization.index', [
            'membersByRole' => $membersByRole,
            'users' => $users,
        ]);
    }

    public function store(StoreQmsOrganizationMemberRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $role = QmsOrganizationRole::from($validated['role']);
        $userId = (int) $validated['user_id'];

        if ($role->isSingleton()) {
            QmsOrganizationMember::query()
                ->where('role', $role->value)
                ->where('user_id', '!=', $userId)
                ->delete();

            QmsOrganizationMember::query()->updateOrCreate([
                'role' => $role->value,
                'user_id' => $userId,
            ], [
                'display_order' => 1,
            ]);

            return redirect()->route('admin.qms-organization.index')->with('success', $role->label().' has been updated.');
        }

        $alreadyAssigned = QmsOrganizationMember::query()
            ->where('role', $role->value)
            ->where('user_id', $userId)
            ->exists();

        if ($alreadyAssigned) {
            return redirect()->route('admin.qms-organization.index')->with('success', 'The selected user is already in QMS Secretariat Team Members.');
        }

        $nextOrder = (int) QmsOrganizationMember::query()
            ->where('role', $role->value)
            ->max('display_order') + 1;

        QmsOrganizationMember::query()->create([
            'role' => $role->value,
            'user_id' => $userId,
            'display_order' => $nextOrder,
        ]);

        return redirect()->route('admin.qms-organization.index')->with('success', 'QMS Secretariat Team Member has been added.');
    }

    public function destroy(QmsOrganizationMember $qmsOrganizationMember): RedirectResponse
    {
        $roleLabel = $qmsOrganizationMember->role->label();
        $qmsOrganizationMember->delete();

        return redirect()->route('admin.qms-organization.index')->with('success', $roleLabel.' assignment has been removed.');
    }
}
