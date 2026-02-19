<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;



Route::get('/', function () {
    // If the user is already authenticated, send them to the games dashboard.
    // This avoids a RedirectIfAuthenticated -> '/' -> '/login' loop when
    // the guest middleware redirects authenticated users back to '/'.
    if (Auth::check()) {
        return redirect()->route('games.index');
    }

    return redirect()->route('login');
});



Route::middleware(['auth'])->group(function () {

    
    Route::resource('games', GameController::class);
    Route::post('games/{game}/join', [App\Http\Controllers\GameController::class, 'join'])->name('games.join');
    Route::post('games/{game}/leave', [App\Http\Controllers\GameController::class, 'leave'])->name('games.leave');

    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Tournaments: creation protected by user permission
    Route::resource('tournaments', \App\Http\Controllers\TournamentController::class);

    // Tickets for moderator applications / support
    Route::get('tickets/create', [\App\Http\Controllers\TicketController::class, 'create'])->name('tickets.create');
    Route::post('tickets', [\App\Http\Controllers\TicketController::class, 'store'])->name('tickets.store');
    Route::get('tickets', [\App\Http\Controllers\TicketController::class, 'index'])->name('tickets.index');
    Route::post('tickets/{ticket}/approve', [\App\Http\Controllers\TicketController::class, 'approve'])->name('tickets.approve');
    Route::post('tickets/{ticket}/reject', [\App\Http\Controllers\TicketController::class, 'reject'])->name('tickets.reject');
});

require __DIR__.'/auth.php';

// Public user profile (banner / avatar / bio)
Route::get('/users/{user}', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
