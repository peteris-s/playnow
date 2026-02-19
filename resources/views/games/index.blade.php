<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Games') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Games</h1>
                    <a href="{{ route('games.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">Create Game</a>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
                    <form method="GET" action="{{ route('games.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                        <input name="q" value="{{ request('q') }}" placeholder="Search sport or location" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded" />
                        <input name="sport" value="{{ request('sport') }}" placeholder="Sport (e.g. Football)" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded" />
                        <input name="location" value="{{ request('location') }}" placeholder="Location" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded" />
                        <div class="text-right">
                            <button class="px-3 py-2 bg-indigo-600 text-white rounded">Filter</button>
                        </div>
                    </form>
                </div>
                <div class="grid grid-cols-1 gap-6">
                    @forelse($games as $game)
                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4 flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-3">
                                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $game->sport_type }} — <span class="game-time" data-utc="{{ $game->game_time->toIso8601String() }}">{{ $game->game_time->format('Y-m-d H:i') }}</span></h3>
                                    @if($game->status === 'in_progress')
                                        <span class="text-xs bg-indigo-600 text-white px-2 py-1 rounded">In progress</span>
                                    @elseif($game->status === 'started')
                                        <span class="text-xs bg-gray-600 text-white px-2 py-1 rounded">Started</span>
                                    @else
                                        <span class="text-xs bg-green-600 text-white px-2 py-1 rounded">Upcoming</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500">Location: {{ $game->location ?? 'TBA' }} · Host:
                                    @if(optional($game->creator)->profile_photo_path)
                                        <a href="{{ route('profile.show', $game->creator) }}">
                                            <img src="{{ asset('storage/'.optional($game->creator)->profile_photo_path) }}" alt="host" class="inline-block w-6 h-6 rounded-full object-cover align-text-bottom" />
                                        </a>
                                    @endif
                                    {{ optional($game->creator)->real_name ?? optional($game->creator)->name }}
                                    @if(optional($game->creator)->city || optional($game->creator)->age_group)
                                        <span class="text-xs text-gray-400 ms-2">
                                            @if(optional($game->creator)->city) <span>• {{ optional($game->creator)->city }}</span> @endif
                                            @if(optional($game->creator)->age_group) <span class="ms-2">• {{ optional($game->creator)->age_group }}</span> @endif
                                        </span>
                                    @endif
                                </p>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ \Illuminate\Support\Str::limit($game->notes, 150) }}</p>

                                <div class="mt-3 text-sm">
                                    <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded">Confirmed: {{ $game->confirmed_count }}/{{ $game->max_players }}</span>
                                    <span class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded ms-2">Reserve: {{ $game->reserve_count }}</span>
                                </div>
                            </div>

                            <div class="text-right">
                                <a href="{{ route('games.show', $game) }}" class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded">Details</a>

                                @php $joined = $game->users()->where('user_id', auth()->id())->exists(); @endphp

                                @if($joined)
                                    <form method="POST" action="{{ route('games.leave', $game) }}" class="inline-block ms-2">
                                        @csrf
                                        <button class="px-3 py-2 bg-red-600 text-white rounded">Leave</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('games.join', $game) }}" class="inline-block ms-2">
                                        @csrf
                                        <button class="px-3 py-2 bg-green-600 text-white rounded">Join</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                            <p class="text-gray-600">No games found. Create the first one!</p>
                        </div>
                    @endforelse

                    <script>
                        // Convert server UTC timestamps to the visitor's local timezone for display
                        (function(){
                            try {
                                document.querySelectorAll('[data-utc]').forEach(function(el){
                                    var utc = el.getAttribute('data-utc');
                                    if (!utc) return;
                                    var d = new Date(utc);
                                    if (isNaN(d.getTime())) return;
                                    el.textContent = d.toLocaleString();
                                });
                            } catch(e) {}
                        })();
                    </script>

                    <div class="mt-4">{{ $games->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
