<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Game;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'real_name',
        'email',
        'password',
        'no_shows',
        'bio',
        'profile_photo_path',
        'profile_banner_path',
        'city',
        'age_group',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class)->withPivot('status')->withTimestamps();
    }

    public function confirmedGames(): BelongsToMany
    {
        return $this->games()->wherePivot('status', 'confirmed');
    }

    public function reserveGames(): BelongsToMany
    {
        return $this->games()->wherePivot('status', 'reserve');
    }
}
