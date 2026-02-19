<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        // Allow flexible, typed locations while keeping sport restricted to our configured list
        $placesMap = config('latvia_places.places', []);
        $sports = array_keys($placesMap);

        $sportRule = ['required', 'string', Rule::in($sports)];

        // Allow free-text location so users can type custom venues/cities; we still enforce length
        $locationRule = ['required', 'string', 'max:255'];

        return [
            'sport_type' => $sportRule,
            'location' => $locationRule,
            'game_time' => ['required', 'date', 'after:now'],
            'max_players' => ['required', 'integer', 'min:2', 'max:100'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
