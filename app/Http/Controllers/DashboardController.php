<?php

namespace App\Http\Controllers;

use App\Models\PlayerProfile;
use App\Models\ScoutProfile;
use App\Models\ScoutingInterest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard customized for their role.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $data = [
            'user' => $user,
            'role' => $user->role,
        ];

        if ($user->isPlayer()) {
            $playerProfile = $user->playerProfile;

            $interests = $playerProfile
                ? $playerProfile->scoutingInterests()
                    ->with(['scout.scoutProfile'])
                    ->latest()
                    ->take(5)
                    ->get()
                : collect();

            $data['playerProfile'] = $playerProfile;
            $data['recentInterests'] = $interests;
            $data['totalInterestsCount'] = $playerProfile ? $playerProfile->scoutingInterests()->count() : 0;
            $data['pendingInterestsCount'] = $playerProfile ? $playerProfile->scoutingInterests()->where('status', ScoutingInterest::STATUS_PENDING)->count() : 0;
            $data['unreadNotificationsCount'] = $user->unreadNotifications()->count();
        } elseif ($user->isScout()) {
            $scoutProfile = $user->scoutProfile;

            $interests = $user->sentScoutingInterests()
                ->with(['playerProfile.user'])
                ->latest()
                ->take(5)
                ->get();

            $data['scoutProfile'] = $scoutProfile;
            $data['recentInterests'] = $interests;
            $data['totalInterestsCount'] = $user->sentScoutingInterests()->count();
            $data['pendingInterestsCount'] = $user->sentScoutingInterests()->where('status', ScoutingInterest::STATUS_PENDING)->count();
            $data['contactedInterestsCount'] = $user->sentScoutingInterests()->where('status', ScoutingInterest::STATUS_CONTACTED)->count();
            $data['unreadNotificationsCount'] = $user->unreadNotifications()->count();
        } elseif ($user->isAdmin()) {
            $data['adminStats'] = [
                'total_users' => User::count(),
                'total_players' => User::where('role', User::ROLE_PLAYER)->count(),
                'total_scouts' => User::where('role', User::ROLE_SCOUT)->count(),
                'total_player_profiles' => PlayerProfile::count(),
                'total_scout_profiles' => ScoutProfile::count(),
                'total_scouting_interests' => ScoutingInterest::count(),
            ];

            $data['recentInterests'] = ScoutingInterest::with(['scout.scoutProfile', 'playerProfile.user'])
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', $data);
    }
}
