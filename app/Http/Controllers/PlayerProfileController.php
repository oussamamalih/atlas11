<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerProfileRequest;
use App\Models\PlayerProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerProfileController extends Controller
{
    /**
     * Redirect to the player's profile or create page.
     */
    public function index(Request $request): RedirectResponse
    {
        if (! $request->user()->isPlayer()) {
            return redirect()->route('dashboard');
        }

        $profile = $request->user()->playerProfile;

        if ($profile) {
            return redirect()->route('player.profile.show', $profile);
        }

        return redirect()->route('player.profile.create');
    }

    /**
     * Show the form for creating a new player profile.
     */
    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->user()->isPlayer()) {
            abort(403, 'Only players can create a player profile.');
        }

        if ($request->user()->playerProfile()->exists()) {
            return redirect()->route('player.profile.edit')
                ->with('status', 'You already have a football profile. You can edit it here.');
        }

        return view('player.create', [
            'positions' => PlayerProfile::POSITIONS,
            'preferredFeet' => PlayerProfile::PREFERRED_FEET,
        ]);
    }

    /**
     * Store a newly created player profile in storage.
     */
    public function store(PlayerProfileRequest $request): RedirectResponse
    {
        if (! $request->user()->isPlayer()) {
            abort(403, 'Only players can create a player profile.');
        }

        if ($request->user()->playerProfile()->exists()) {
            return redirect()->route('player.profile.edit');
        }

        $profile = $request->user()->playerProfile()->create($request->validated());

        return redirect()->route('player.profile.show', $profile)
            ->with('status', 'Football profile created successfully!');
    }

    /**
     * Display the specified player profile.
     */
    public function show(PlayerProfile $playerProfile): View
    {
        $playerProfile->load('user');

        return view('player.show', [
            'profile' => $playerProfile,
        ]);
    }

    /**
     * Show the form for editing the authenticated player's profile.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        if (! $request->user()->isPlayer()) {
            abort(403, 'Only players can edit their player profile.');
        }

        $profile = $request->user()->playerProfile;

        if (! $profile) {
            return redirect()->route('player.profile.create');
        }

        return view('player.edit', [
            'profile' => $profile,
            'positions' => PlayerProfile::POSITIONS,
            'preferredFeet' => PlayerProfile::PREFERRED_FEET,
        ]);
    }

    /**
     * Update the authenticated player's profile in storage.
     */
    public function update(PlayerProfileRequest $request): RedirectResponse
    {
        if (! $request->user()->isPlayer()) {
            abort(403, 'Only players can update their player profile.');
        }

        $profile = $request->user()->playerProfile;

        if (! $profile) {
            return redirect()->route('player.profile.create');
        }

        $profile->update($request->validated());

        return redirect()->route('player.profile.show', $profile)
            ->with('status', 'Football profile updated successfully!');
    }
}
