<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    public function index()
    {
        $tournaments = Tournament::with('organizer')->orderBy('start_at','asc')->paginate(12);
        return view('tournaments.index', compact('tournaments'));
    }

    public function show(Tournament $tournament)
    {
        return view('tournaments.show', compact('tournament'));
    }

    public function create()
    {
        // only users with permission
        if (! Auth::user()->can_create_tournaments) {
            abort(403);
        }
        return view('tournaments.create');
    }

    public function store(Request $request)
    {
        if (! Auth::user()->can_create_tournaments) abort(403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'sport_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'start_at' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $data['organizer_id'] = Auth::id();

        $t = Tournament::create($data);

        return redirect()->route('tournaments.show', $t)->with('success','Tournament created.');
    }
}
