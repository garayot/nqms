<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\FuncDiv;
use App\Models\Office;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->with(['position', 'officeLookup', 'functionalDivLookup'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($searchQuery) use ($search): void {
                    $searchQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('office', 'like', "%{$search}%")
                        ->orWhereHas('officeLookup', function ($officeQuery) use ($search): void {
                            $officeQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('functionalDivLookup', function ($functionalDivQuery) use ($search): void {
                            $functionalDivQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $offices = Office::query()
            ->orderBy('name')
            ->get();

        $functionalDivs = FuncDiv::query()
            ->orderBy('name')
            ->get();

        $positions = Position::query()
            ->orderBy('position_name')
            ->get();

        $roles = UserRole::cases();

        return view('admin.users.index', compact('users', 'roles', 'positions', 'offices', 'functionalDivs'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:'.implode(',', array_map(fn ($case) => $case->value, UserRole::cases()))],
            'position_id' => ['nullable', 'exists:positions,id'],
            'office_id' => ['nullable', 'exists:offices,id'],
            'functional_div_id' => ['nullable', 'exists:func_div,id'],
        ]);

        $office = filled($request->office_id)
            ? Office::query()->find($request->office_id)
            : null;

        $user->role = $request->role;
        $user->position_id = $request->position_id;
        $user->office_id = $request->office_id;
        $user->functional_div_id = $request->functional_div_id;
        $user->office = $office?->name;
        $user->save();

        return back()->with('success', 'User profile updated.');
    }
}
