<?php

namespace App\Http\Controllers;

use App\Models\PlayerProfile;
use App\Models\ScoutProfile;
use App\Models\ScoutingInterest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with platform metrics and recent activities.
     */
    public function index(Request $request): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_players' => User::where('role', User::ROLE_PLAYER)->count(),
            'total_scouts' => User::where('role', User::ROLE_SCOUT)->count(),
            'total_admins' => User::where('role', User::ROLE_ADMIN)->count(),
            'total_player_profiles' => PlayerProfile::count(),
            'total_scout_profiles' => ScoutProfile::count(),
            'total_scouting_interests' => ScoutingInterest::count(),
            'pending_interests' => ScoutingInterest::where('status', ScoutingInterest::STATUS_PENDING)->count(),
            'contacted_interests' => ScoutingInterest::where('status', ScoutingInterest::STATUS_CONTACTED)->count(),
        ];

        $recentUsers = User::latest()->take(6)->get();

        $recentInterests = ScoutingInterest::with(['scout.scoutProfile', 'playerProfile.user'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'recentInterests' => $recentInterests,
        ]);
    }
}
