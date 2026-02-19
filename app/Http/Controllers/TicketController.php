<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Users submit tickets
    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $data['user_id'] = Auth::id();
        $ticket = Ticket::create($data);

        return redirect()->route('tickets.create')->with('success','Ticket submitted. Moderators will review it.');
    }

    // Moderator views
    public function index()
    {
        $user = Auth::user();
        if (! $user->is_moderator) abort(403);

        $tickets = Ticket::with('user')->orderBy('created_at','desc')->paginate(20);
        return view('tickets.index', compact('tickets'));
    }

    public function approve(Ticket $ticket, Request $request)
    {
        $user = Auth::user();
        if (! $user->is_moderator) abort(403);

        // grant permission to the ticket owner
        $ticket->status = 'approved';
        $ticket->moderator_note = $request->input('note');
        $ticket->save();

        $owner = $ticket->user;
        $owner->can_create_tournaments = true;
        $owner->save();

        return redirect()->route('tickets.index')->with('success','Ticket approved and permission granted.');
    }

    public function reject(Ticket $ticket, Request $request)
    {
        $user = Auth::user();
        if (! $user->is_moderator) abort(403);

        $ticket->status = 'rejected';
        $ticket->moderator_note = $request->input('note');
        $ticket->save();

        return redirect()->route('tickets.index')->with('success','Ticket rejected.');
    }
}
