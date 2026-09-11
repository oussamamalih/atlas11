<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\PlayerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the scout's favorited player profiles.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        if (! $user->isScout()) {
            abort(403, 'Only scouts can access bookmarked talent shortlists.');
        }

        $favorites = $user->favorites()
            ->with(['playerProfile.user'])
            ->latest()
            ->paginate(12);

        return view('favorites.index', [
            'favorites' => $favorites,
        ]);
    }

    /**
     * Bookmark / Favorite a player profile.
     */
    public function store(Request $request, PlayerProfile $playerProfile): RedirectResponse|JsonResponse
    {
        $user = $request->user();

        if (! $user->isScout()) {
            abort(403, 'Only scouts can bookmark player profiles.');
        }

        $favorite = Favorite::firstOrCreate([
            'scout_id' => $user->id,
            'player_profile_id' => $playerProfile->id,
        ]);

        $message = __('Player :name successfully added to your shortlisted favorites.', [
            'name' => $playerProfile->user->name ?? __('Player'),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'favorited',
                'is_favorited' => true,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('status', $message);
    }

    /**
     * Remove a player profile from favorites.
     */
    public function destroy(Request $request, PlayerProfile $playerProfile): RedirectResponse|JsonResponse
    {
        $user = $request->user();

        if (! $user->isScout()) {
            abort(403, 'Only scouts can manage bookmarked player profiles.');
        }

        Favorite::where('scout_id', $user->id)
            ->where('player_profile_id', $playerProfile->id)
            ->delete();

        $message = __('Player :name removed from your favorites.', [
            'name' => $playerProfile->user->name ?? __('Player'),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'unfavorited',
                'is_favorited' => false,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('status', $message);
    }
}
