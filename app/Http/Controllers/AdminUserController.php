<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display a listing of users with search and filtering capabilities.
     */
    public function index(Request $request): View
    {
        $query = User::query()->with(['playerProfile', 'scoutProfile']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $role = $request->input('role');
            if (in_array($role, [User::ROLE_PLAYER, User::ROLE_SCOUT, User::ROLE_ADMIN])) {
                $query->where('role', $role);
            }
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'filters' => [
                'search' => $request->input('search', ''),
                'role' => $request->input('role', ''),
            ],
            'roles' => [
                User::ROLE_PLAYER => 'Player',
                User::ROLE_SCOUT => 'Scout',
                User::ROLE_ADMIN => 'Admin',
            ],
        ]);
    }

    /**
     * Display the specified user's details.
     */
    public function show(User $user): View
    {
        $user->load(['playerProfile.scoutingInterests.scout', 'scoutProfile', 'sentScoutingInterests.playerProfile.user']);

        return view('admin.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => [
                User::ROLE_PLAYER => 'Player',
                User::ROLE_SCOUT => 'Scout',
                User::ROLE_ADMIN => 'Administrator',
            ],
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'role' => [
                'required',
                'string',
                Rule::in([User::ROLE_PLAYER, User::ROLE_SCOUT, User::ROLE_ADMIN]),
            ],
        ]);

        // Prevent self-demotion
        if ($request->user()->id === $user->id && $validated['role'] !== User::ROLE_ADMIN) {
            return redirect()->back()->with('error', 'You cannot remove your own administrator role.');
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('status', "User '{$user->name}' updated successfully.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        // Prevent self-deletion
        if ($request->user()->id === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account from the administrator panel.');
        }

        $userName = $user->name;

        // Delete notifications first to prevent orphan polymorphic records
        $user->notifications()->delete();
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('status', "User '{$userName}' was deleted successfully.");
    }
}
