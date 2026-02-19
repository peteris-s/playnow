<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Submit Application / Ticket</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="post" action="{{ route('tickets.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Subject</label>
                            <input name="subject" required class="mt-1 block w-full" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea name="message" rows="6" class="mt-1 block w-full" required></textarea>
                        </div>
                        <div class="text-right">
                            <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>