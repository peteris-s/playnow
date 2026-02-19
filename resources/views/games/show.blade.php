<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $game->sport_type }} — <span class="game-time" data-utc="{{ $game->game_time->toIso8601String() }}">{{ $game->game_time->format('Y-m-d H:i') }}</span></h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <div class="flex items-center gap-3">
                    <p class="text-sm text-gray-500">Location: {{ $game->location }}</p>
                    @if(isset($status) && $status === 'in_progress')
                        <span class="text-xs bg-indigo-600 text-white px-2 py-1 rounded">In progress</span>
                    @endif
                </div>
                <p class="text-sm text-gray-500">Max players: {{ $game->max_players }}</p>
                <p class="mt-4">{{ $game->notes }}</p>

                <div class="mt-6">
                    <h3 class="font-semibold">Participants ({{ $confirmed->count() }})</h3>
                    <ul class="mt-2 space-y-3">
                        @foreach($confirmed as $u)
                            <li class="flex items-center gap-3">
                                <a href="{{ route('profile.show', $u) }}">
                                    @if($u->profile_photo_path)
                                        <img src="{{ asset('storage/'.$u->profile_photo_path) }}" alt="{{ $u->real_name ?? $u->name }}" class="w-10 h-10 rounded-full object-cover" />
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center"> <span class="text-gray-600 dark:text-gray-300">@</span></div>
                                    @endif
                                </a>

                                <div>
                                    <a href="{{ route('profile.show', $u) }}" class="font-medium text-gray-900 dark:text-gray-100">{{ $u->real_name ?? $u->name }}</a>
                                    @if($u->email) <div class="text-xs text-gray-400">{{ $u->email }}</div>@endif
                                    @if($u->city || $u->age_group)
                                        <div class="text-xs text-gray-400">
                                            @if($u->city) <span>City: {{ $u->city }}</span>@endif
                                            @if($u->age_group) <span class="ms-4">Age: {{ $u->age_group }}</span>@endif
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <h3 class="font-semibold mt-4">Reserve ({{ $reserve->count() }})</h3>
                    <ul class="mt-2 space-y-3">
                        @foreach($reserve as $u)
                            <li class="flex items-center gap-3">
                                <a href="{{ route('profile.show', $u) }}">
                                    @if($u->profile_photo_path)
                                        <img src="{{ asset('storage/'.$u->profile_photo_path) }}" alt="{{ $u->real_name ?? $u->name }}" class="w-10 h-10 rounded-full object-cover" />
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center"> <span class="text-gray-600 dark:text-gray-300">@</span></div>
                                    @endif
                                </a>

                                <div>
                                    <a href="{{ route('profile.show', $u) }}" class="font-medium text-gray-900 dark:text-gray-100">{{ $u->real_name ?? $u->name }}</a>
                                    @if($u->email) <div class="text-xs text-gray-400">{{ $u->email }}</div>@endif
                                    @if($u->city || $u->age_group)
                                        <div class="text-xs text-gray-400">
                                            @if($u->city) <span>City: {{ $u->city }}</span>@endif
                                            @if($u->age_group) <span class="ms-4">Age: {{ $u->age_group }}</span>@endif
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-6">
                        <p>Spots left: <strong>{{ $spotsLeft }}</strong></p>
                    </div>

                    <div class="mt-4">
                        <form method="POST" action="{{ route('games.join', $game) }}" class="inline">
                            @csrf
                            <button class="px-3 py-2 bg-green-600 text-white rounded">Join</button>
                        </form>

                        <form method="POST" action="{{ route('games.leave', $game) }}" class="inline ms-2">
                            @csrf
                            <button class="px-3 py-2 bg-red-600 text-white rounded">Leave</button>
                        </form>

                        @if(auth()->id() === $game->creator_id)
                            <form method="POST" action="{{ route('games.destroy', $game) }}" class="inline ms-2">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 bg-gray-700 text-white rounded">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
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
</x-app-layout>
