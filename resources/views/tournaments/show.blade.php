<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $tournament->title }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold">{{ $tournament->title }}</h3>
                <p class="text-sm text-gray-500">{{ $tournament->sport_type }} · {{ $tournament->location }} · Organized by <a href="{{ route('profile.show', $tournament->organizer) }}">{{ $tournament->organizer->real_name ?? $tournament->organizer->name }}</a></p>

                <div class="mt-4">{!! nl2br(e($tournament->description)) !!}</div>
            </div>
        </div>
    </div>
</x-app-layout>