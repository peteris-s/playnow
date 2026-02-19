<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'sport_type',
        'location',
        'game_time',
        'max_players',
        'notes',
    ];

    protected $casts = [
        'game_time' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('status')
            ->withTimestamps();
    }

    public function confirmedUsers()
    {
        return $this->users()->wherePivot('status', 'confirmed');
    }

    public function reserveUsers()
    {
        return $this->users()->wherePivot('status', 'reserve');
    }
}
