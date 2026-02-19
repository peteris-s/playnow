<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->real_name ?? $user->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                {{-- Banner --}}
                @if($user->profile_banner_path)
                    <div class="w-full h-48 bg-gray-200 dark:bg-gray-700">
                        <img src="{{ asset('storage/'.$user->profile_banner_path) }}" alt="Banner" class="w-full h-48 object-cover" />
                    </div>
                @else
                    <div class="w-full h-48 bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                        <span class="text-gray-600 dark:text-gray-300">Banner</span>
                    </div>
                @endif

                <div class="p-6 flex gap-4 items-start">
                    <div>
                        @if($user->profile_photo_path)
                            <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Avatar" class="w-28 h-28 object-cover rounded-full border-2 border-white shadow" />
                        @else
                            <div class="w-28 h-28 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center"> 
                                <span class="text-gray-600 dark:text-gray-300">Avatar</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $user->real_name ?? $user->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ '@' . $user->name }}</p>

                        @if($user->bio)
                            <div class="mt-4 text-gray-700 dark:text-gray-300">{!! nl2br(e($user->bio)) !!}</div>
                        @else
                            <div class="mt-4 text-gray-500 dark:text-gray-400">No bio provided.</div>
                        @endif
                        <div class="mt-3 text-sm text-gray-500">
                            @if($user->city) <span>City: {{ $user->city }}</span>@endif
                            @if($user->age_group) <span class="ms-4">Age: {{ $user->age_group }}</span>@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
