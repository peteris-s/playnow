<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Tournaments') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Tournaments</h1>
                    @auth
                        @if(auth()->user()->can_create_tournaments)
                            <a href="{{ route('tournaments.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">Create Tournament</a>
                        @else
                            <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md">Apply to create tournaments</a>
                        @endif
                    @endauth
                </div>

                <div class="grid grid-cols-1 gap-6">
                    @forelse($tournaments as $t)
                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
                            <h3 class="font-semibold text-lg">{{ $t->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $t->sport_type }} · {{ $t->location }} · Organizer: <a href="{{ route('profile.show', $t->organizer) }}">{{ $t->organizer->real_name ?? $t->organizer->name }}</a></p>
                            <p class="mt-2 text-sm">{{ \Illuminate\Support\Str::limit($t->description, 200) }}</p>
                            <div class="mt-3 text-right">
                                <a href="{{ route('tournaments.show', $t) }}" class="px-3 py-2 bg-gray-200 dark:bg-gray-700 rounded">Details</a>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                            <p class="text-gray-600">No tournaments scheduled.</p>
                        </div>
                    @endforelse

                    <div class="mt-4">{{ $tournaments->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>