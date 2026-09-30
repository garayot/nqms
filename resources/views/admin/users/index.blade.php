@extends('layouts.app')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">User Management</h1>
                <p class="mt-2 text-sm text-slate-600">Manage roles for DepEd users.</p>
            </div>
            <form method="GET" class="w-full max-w-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search user" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#0f3d68] focus:outline-none">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-700">Name</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Email</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Office</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Functional Division</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Position</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Role</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Update</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->officeLookup?->name ?? $user->office ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $user->functionalDivLookup?->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $user->position?->position_name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $user->role?->label() ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.users.role', $user) }}" class="space-y-2">
                                    @csrf
                                    <div class="grid gap-2 lg:grid-cols-2">
                                        <select name="position_id" class="rounded-lg border border-slate-300 px-2 py-2 text-sm">
                                            <option value="">No position</option>
                                            @foreach ($positions as $position)
                                                <option value="{{ $position->id }}" @selected((string) $user->position_id === (string) $position->id)>{{ $position->position_name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="office_id" class="rounded-lg border border-slate-300 px-2 py-2 text-sm">
                                            <option value="">No office</option>
                                            @foreach ($offices as $office)
                                                <option value="{{ $office->id }}" @selected((string) $user->office_id === (string) $office->id)>{{ $office->name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="functional_div_id" class="rounded-lg border border-slate-300 px-2 py-2 text-sm">
                                            <option value="">No functional division</option>
                                            @foreach ($functionalDivs as $functionalDiv)
                                                <option value="{{ $functionalDiv->id }}" @selected((string) $user->functional_div_id === (string) $functionalDiv->id)>{{ $functionalDiv->name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="role" class="rounded-lg border border-slate-300 px-2 py-2 text-sm">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->value }}" {{ $user->role?->value === $role->value ? 'selected' : '' }}>{{ $role->label() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="rounded-md bg-[#0f3d68] px-3 py-2 text-xs font-semibold text-white">Save</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
@endsection
