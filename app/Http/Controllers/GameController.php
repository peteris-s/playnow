<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Exclude games that started more than 2 hours ago (expired)
        $threshold = now()->subHours(2);

        $games = Game::where('game_time', '>=', $threshold)
            ->withCount([
                'users as confirmed_count' => function ($q) {
                    $q->where('status', 'confirmed');
                },
                'users as reserve_count' => function ($q) {
                    $q->where('status', 'reserve');
                }
            ])->with('creator')->orderBy('game_time', 'asc')->paginate(12);

        // Compute status server-side to avoid Blade/Carbon timezone quirks
        $games->getCollection()->transform(function ($game) {
            // Normalize times to the application timezone to avoid timezone comparison issues
            $now = now()->setTimezone(config('app.timezone'));
            $start = $game->game_time->copy()->setTimezone(config('app.timezone'));
            $end = $start->copy()->addHours(2);

            if ($now->gte($start) && $now->lt($end)) {
                $game->status = 'in_progress';
            } elseif ($now->lt($start)) {
                $game->status = 'upcoming';
            } else {
                $game->status = 'started';
            }

            return $game;
        });

        return view('games.index', compact('games'));
    }

    public function create()
    {
        if (!Auth::user()->real_name) {
            return redirect()->route('profile.edit')->with('info', 'Please enter your real name before creating a game.');
        }

        return view('games.create');
    }

    public function store(GameRequest $request)
    {
        $data = $request->validated();

        // If the browser provided a timezone (from JS), parse the datetime-local value using
        // that timezone so the stored timestamp is normalized to UTC. Browsers submit
        // datetime-local values without timezone info.
        $tz = $request->input('timezone', config('app.timezone'));
        if (!empty($data['game_time'])) {
            // datetime-local input format: YYYY-MM-DDTHH:MM
            try {
                $dt = Carbon::createFromFormat('Y-m-d\TH:i', $data['game_time'], $tz);
                // Store in UTC to keep DB consistent
                $data['game_time'] = $dt->setTimezone('UTC');
            } catch (\Exception $e) {
                // Fallback: let Eloquent/DB try to store the raw value
            }
        }

        $data['creator_id'] = Auth::id();

        $game = Game::create($data);

        // Add creator as confirmed participant
        $game->users()->attach(Auth::id(), ['status' => 'confirmed']);

        return redirect()->route('games.show', $game)->with('success', 'Game created.');
    }

    public function show(Game $game)
    {
        $game->load(['users']);

        // Normalize times to the application timezone to avoid timezone comparison issues
        $now = now()->setTimezone(config('app.timezone'));
        $start = $game->game_time->copy()->setTimezone(config('app.timezone'));
        $end = $start->copy()->addHours(2);

        // If the game expired (started >2 hours ago), redirect back
        if ($now->gt($end)) {
            return redirect()->route('games.index')->with('info', 'This game has finished and is no longer available.');
        }

        $confirmed = $game->users()->wherePivot('status', 'confirmed')->get();
        $reserve = $game->users()->wherePivot('status', 'reserve')->get();

        $spotsLeft = max(0, $game->max_players - $confirmed->count());

        // Compute status for the show view as well
        if ($now->gte($start) && $now->lt($end)) {
            $status = 'in_progress';
        } elseif ($now->lt($start)) {
            $status = 'upcoming';
        } else {
            $status = 'started';
        }

        return view('games.show', compact('game', 'confirmed', 'reserve', 'spotsLeft', 'status'));
    }

    public function join(Game $game)
    {
        $user = Auth::user();
        if (! $user->real_name) {
            return redirect()->route('profile.edit')->with('info', 'Please enter your real name before joining a game.');
        }

        // Do not allow joining if the game expired (>2 hours since start)
        if (now()->gt($game->game_time->copy()->addHours(2))) {
            return back()->with('info', 'This game has already finished and cannot be joined.');
        }

        if ($game->users()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'You are already registered for this game.');
        }

        $confirmedCount = $game->users()->wherePivot('status', 'confirmed')->count();

        $status = $confirmedCount < $game->max_players ? 'confirmed' : 'reserve';

        $game->users()->attach($user->id, ['status' => $status]);

        return back()->with('success', $status === 'confirmed' ? 'You joined the game.' : 'You were added to the reserve list.');
    }

    public function leave(Game $game)
    {
        $user = Auth::user();

        if (! $game->users()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'You are not part of this game.');
        }

        // If the leaving user was confirmed, promote first reserve to confirmed
        $wasConfirmed = $game->users()->where('user_id', $user->id)->wherePivot('status', 'confirmed')->exists();

        $game->users()->detach($user->id);

        if ($wasConfirmed) {
            $next = $game->users()->wherePivot('status', 'reserve')->orderBy('game_user.created_at')->first();
            if ($next) {
                $game->users()->updateExistingPivot($next->id, ['status' => 'confirmed']);
            }
        }

        return back()->with('success', 'You left the game.');
    }

    public function destroy(Game $game)
    {
        // Allow only the creator to delete the game
        if (Auth::id() !== $game->creator_id) {
            abort(403);
        }

        $game->delete();

        return redirect()->route('games.index')->with('success', 'Game removed.');
    }
}
