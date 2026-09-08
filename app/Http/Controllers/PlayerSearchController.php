<?php

namespace App\Http\Controllers;

use App\Models\PlayerProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerSearchController extends Controller
{
    /**
     * Display the player search and filter interface.
     */
    public function index(Request $request): View
    {
        if (! $request->user()->isScout() && ! $request->user()->isAdmin()) {
            abort(403, 'Only scouts and administrators can access player search.');
        }

        $query = PlayerProfile::with('user');

        // Filter by keyword (player name or bio)
        if ($request->filled('keyword')) {
            $keyword = trim($request->input('keyword'));
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('user', function ($uq) use ($keyword) {
                    $uq->where('name', 'like', "%{$keyword}%");
                })->orWhere('bio', 'like', "%{$keyword}%")
                  ->orWhere('football_experience', 'like', "%{$keyword}%")
                  ->orWhere('current_club', 'like', "%{$keyword}%");
            });
        }

        // Filter by position
        if ($request->filled('position')) {
            $query->where('position', $request->input('position'));
        }

        // Filter by location / city
        if ($request->filled('location')) {
            $location = trim($request->input('location'));
            $query->where('location', 'like', "%{$location}%");
        }

        // Filter by preferred foot
        if ($request->filled('preferred_foot')) {
            $query->where('preferred_foot', $request->input('preferred_foot'));
        }

        // Filter by minimum age (older than or equal to min_age)
        if ($request->filled('min_age')) {
            $minAge = (int) $request->input('min_age');
            $query->where('date_of_birth', '<=', now()->subYears($minAge)->toDateString());
        }

        // Filter by maximum age (younger than or equal to max_age)
        if ($request->filled('max_age')) {
            $maxAge = (int) $request->input('max_age');
            $query->where('date_of_birth', '>=', now()->subYears($maxAge + 1)->addDay()->toDateString());
        }

        $players = $query->latest()->paginate(12)->withQueryString();

        return view('scout.search', [
            'players' => $players,
            'positions' => PlayerProfile::POSITIONS,
            'preferredFeet' => PlayerProfile::PREFERRED_FEET,
        ]);
    }
}
