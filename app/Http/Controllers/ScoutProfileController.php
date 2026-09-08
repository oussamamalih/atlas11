<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScoutProfileRequest;
use App\Models\ScoutProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScoutProfileController extends Controller
{
    /**
     * Redirect to the scout's profile or create page.
     */
    public function index(Request $request): RedirectResponse
    {
        if (! $request->user()->isScout()) {
            return redirect()->route('dashboard');
        }

        $profile = $request->user()->scoutProfile;

        if ($profile) {
            return redirect()->route('scout.profile.show', $profile);
        }

        return redirect()->route('scout.profile.create');
    }

    /**
     * Show the form for creating a new scout profile.
     */
    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->user()->isScout()) {
            abort(403, 'Only scouts can create a scout profile.');
        }

        if ($request->user()->scoutProfile()->exists()) {
            return redirect()->route('scout.profile.edit')
                ->with('status', 'You already have a scout profile. You can edit it here.');
        }

        return view('scout.create');
    }

    /**
     * Store a newly created scout profile in storage.
     */
    public function store(ScoutProfileRequest $request): RedirectResponse
    {
        if (! $request->user()->isScout()) {
            abort(403, 'Only scouts can create a scout profile.');
        }

        if ($request->user()->scoutProfile()->exists()) {
            return redirect()->route('scout.profile.edit');
        }

        $profile = $request->user()->scoutProfile()->create($request->validated());

        return redirect()->route('scout.profile.show', $profile)
            ->with('status', 'Scout profile created successfully!');
    }

    /**
     * Display the specified scout profile.
     */
    public function show(ScoutProfile $scoutProfile): View
    {
        $scoutProfile->load('user');

        return view('scout.show', [
            'profile' => $scoutProfile,
        ]);
    }

    /**
     * Show the form for editing the authenticated scout's profile.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        if (! $request->user()->isScout()) {
            abort(403, 'Only scouts can edit their scout profile.');
        }

        $profile = $request->user()->scoutProfile;

        if (! $profile) {
            return redirect()->route('scout.profile.create');
        }

        return view('scout.edit', [
            'profile' => $profile,
        ]);
    }

    /**
     * Update the authenticated scout's profile in storage.
     */
    public function update(ScoutProfileRequest $request): RedirectResponse
    {
        if (! $request->user()->isScout()) {
            abort(403, 'Only scouts can update their scout profile.');
        }

        $profile = $request->user()->scoutProfile;

        if (! $profile) {
            return redirect()->route('scout.profile.create');
        }

        $profile->update($request->validated());

        return redirect()->route('scout.profile.show', $profile)
            ->with('status', 'Scout profile updated successfully!');
    }
}
