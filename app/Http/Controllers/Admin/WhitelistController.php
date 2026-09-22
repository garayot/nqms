<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhitelistedUser;
use Illuminate\Http\Request;

class WhitelistController extends Controller
{
    public function index(Request $request)
    {
        $whitelist = WhitelistedUser::query()
            ->when($request->search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('office', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.whitelist.index', compact('whitelist'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:whitelisted_users,email'],
            'office' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        WhitelistedUser::create($validated);

        return back()->with('success', 'Authorized user added to whitelist.');
    }

    public function update(Request $request, WhitelistedUser $whitelistedUser)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:whitelisted_users,email,'.$whitelistedUser->id],
            'office' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        $whitelistedUser->update($validated);

        return back()->with('success', 'Whitelist entry updated.');
    }
}
