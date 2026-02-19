<?php

return [
    // Top-level list of sports (display order)
    'sports' => [
        'Basketball',
        'Football',
        'Tennis',
        'Volleyball',
        'Beach Volleyball',
        'Futsal',
        'Running',
        'Skateboarding',
        'Table Tennis',
        'Badminton',
    ],

    // For each sport provide a curated list of common places in Latvia (city + type).
    // These are general venue descriptions (city — venue type) suitable for selecting
    // where the sport will take place. If you want real venue names we can expand
    // this later by fetching municipal venue lists.
    'places' => [
        'Basketball' => [
            'Rīga — Indoor sports hall',
            'Rīga — Outdoor court (park)',
            'Jelgava — School sports hall',
            'Liepāja — Sports arena',
            'Daugavpils — Community sports hall',
            'Ventspils — Sports hall',
            'Valmiera — Sports center',
            'Cēsis — Community sports hall',
            'Rēzekne — Sports hall',
            'Ogre — Gymnasium hall',
        ],
        'Football' => [
            'Rīga — Grass pitch (stadium)',
            'Rīga — Artificial turf (sports complex)',
            'Jūrmala — Beach football (sand)',
            'Liepāja — Municipal field',
            'Daugavpils — Local pitch',
            'Ventspils — Football pitch',
            'Valmiera — Football field',
            'Cēsis — Local pitch',
            'Jelgava — Stadium',
            'Rēzekne — Municipal field',
        ],
        'Tennis' => [
            'Rīga — Indoor tennis courts',
            'Rīga — Outdoor tennis courts (club)',
            'Jelgava — Tennis club',
            'Liepāja — Tennis courts (park)',
            'Valmiera — Tennis courts',
            'Cēsis — Tennis courts',
        ],
        'Volleyball' => [
            'Rīga — Indoor volleyball hall',
            'Jūrmala — Beach volleyball (beach)',
            'Liepāja — Sports hall',
            'Cēsis — Sports hall',
            'Valmiera — Gym sports hall',
        ],
        'Beach Volleyball' => [
            'Jūrmala — Beach (Jūrmala beach area)',
            'Rīga — Sand beach court (Kengarags/park)',
            'Liepāja — Beach area',
        ],
        'Futsal' => [
            'Rīga — Indoor futsal court',
            'Jelgava — Sports hall',
            'Valmiera — Indoor arena',
            'Cēsis — Gym hall',
        ],
        'Running' => [
            'Rīga — Bastejkalns / City Park route',
            'Rīga — Riverside promenade (Daugava embankment)',
            'Jūrmala — Beach promenade',
            'Cēsis — Park routes',
            'Valmiera — Riverside route',
        ],
        'Skateboarding' => [
            'Rīga — Skatepark (city skatepark)',
            'Liepāja — Skatepark',
            'Valmiera — Skatepark',
            'Cēsis — Skate spot',
        ],
        'Table Tennis' => [
            'Rīga — Community center (table tennis)',
            'Jelgava — Sports club',
            'Valmiera — Community sports hall',
            'Cēsis — Community center',
        ],
        'Badminton' => [
            'Rīga — Indoor badminton courts',
            'Jelgava — Sports hall',
            'Valmiera — Badminton courts',
            'Cēsis — Sports hall',
        ],
    ],
];
