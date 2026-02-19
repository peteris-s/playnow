<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Tournament</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="post" action="{{ route('tournaments.store') }}">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <input name="title" required class="mt-1 block w-full" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sport</label>
                            <input name="sport_type" class="mt-1 block w-full" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Location</label>
                            <input name="location" class="mt-1 block w-full" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Start at</label>
                            <input name="start_at" type="datetime-local" class="mt-1 block w-full" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="6" class="mt-1 block w-full"></textarea>
                        </div>

                        <div class="text-right">
                            <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>