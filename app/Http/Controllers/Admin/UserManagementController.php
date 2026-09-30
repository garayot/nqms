<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->with('position')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($searchQuery) use ($search): void {
                    $searchQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $positions = Position::query()
            ->orderBy('position_name')
            ->get();

        $roles = UserRole::cases();

        return view('admin.users.index', compact('users', 'roles', 'positions'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:'.implode(',', array_map(fn ($case) => $case->value, UserRole::cases()))],
            'position_id' => ['nullable', 'exists:positions,id'],
        ]);

        $user->role = $request->role;
        $user->position_id = $request->position_id;
        $user->save();

        return back()->with('success', 'User role and position updated.');
    }
}
