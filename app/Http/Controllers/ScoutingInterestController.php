<?php

namespace App\Http\Controllers;

use App\Models\PlayerProfile;
use App\Models\ScoutingInterest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ScoutingInterestController extends Controller
{
    /**
     * Display a listing of scouting interests for the authenticated user.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isScout()) {
            $interests = $user->sentScoutingInterests()
                ->with(['playerProfile.user'])
                ->latest()
                ->paginate(10);

            return view('scouting.index', [
                'interests' => $interests,
                'role' => 'scout',
            ]);
        }

        if ($user->isPlayer()) {
            $playerProfile = $user->playerProfile;

            if (! $playerProfile) {
                return redirect()->route('player.profile.create')
                    ->with('status', 'Please create your player profile first to receive scouting interests.');
            }

            $interests = $playerProfile->scoutingInterests()
                ->with(['scout.scoutProfile'])
                ->latest()
                ->paginate(10);

            return view('scouting.index', [
                'interests' => $interests,
                'role' => 'player',
            ]);
        }

        return redirect()->route('dashboard');
    }

    /**
     * Store a newly created scouting interest in storage.
     */
    public function store(Request $request, PlayerProfile $playerProfile): RedirectResponse
    {
        if (! $request->user()->isScout()) {
            abort(403, 'Only scouts can express scouting interest.');
        }

        $validated = $request->validate([
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        // Prevent duplicate scouting interests
        $exists = ScoutingInterest::where('scout_id', $request->user()->id)
            ->where('player_profile_id', $playerProfile->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You have already expressed interest in this player.');
        }

        ScoutingInterest::create([
            'scout_id' => $request->user()->id,
            'player_profile_id' => $playerProfile->id,
            'message' => $validated['message'] ?? null,
            'status' => ScoutingInterest::STATUS_PENDING,
        ]);

        return redirect()->back()->with('status', 'Interest successfully expressed in '.$playerProfile->user->name.'!');
    }

    /**
     * Display the specified scouting interest.
     */
    public function show(Request $request, ScoutingInterest $scoutingInterest): View
    {
        $scoutingInterest->load(['scout.scoutProfile', 'playerProfile.user']);

        $user = $request->user();

        // Authorization: only scout, player, or admin
        if ($user->id !== $scoutingInterest->scout_id
            && $user->id !== $scoutingInterest->playerProfile->user_id
            && ! $user->isAdmin()) {
            abort(403, 'You are not authorized to view this scouting interest.');
        }

        // When player views pending interest, mark as viewed
        if ($user->id === $scoutingInterest->playerProfile->user_id
            && $scoutingInterest->status === ScoutingInterest::STATUS_PENDING) {
            $scoutingInterest->update(['status' => ScoutingInterest::STATUS_VIEWED]);
        }

        return view('scouting.show', [
            'interest' => $scoutingInterest,
        ]);
    }

    /**
     * Update the status of the scouting interest.
     */
    public function update(Request $request, ScoutingInterest $scoutingInterest): RedirectResponse
    {
        $user = $request->user();

        if ($user->id !== $scoutingInterest->scout_id
            && $user->id !== $scoutingInterest->playerProfile->user_id
            && ! $user->isAdmin()) {
            abort(403, 'You are not authorized to update this scouting interest.');
        }

        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                Rule::in([
                    ScoutingInterest::STATUS_PENDING,
                    ScoutingInterest::STATUS_VIEWED,
                    ScoutingInterest::STATUS_CONTACTED,
                    ScoutingInterest::STATUS_CLOSED,
                ]),
            ],
        ]);

        $scoutingInterest->update(['status' => $validated['status']]);

        return redirect()->back()->with('status', 'Scouting interest status updated successfully.');
    }
}
