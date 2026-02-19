<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tickets (moderator)</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <table class="w-full">
                    <thead>
                        <tr class="text-left"><th>User</th><th>Subject</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $t)
                            <tr class="border-t">
                                <td class="py-3">{{ $t->user->real_name ?? $t->user->name }}<div class="text-xs text-gray-400">{{ '@'.$t->user->name }}</div></td>
                                <td class="py-3">{{ \Illuminate\Support\Str::limit($t->message, 200) }}</td>
                                <td class="py-3">{{ $t->status }}</td>
                                <td class="py-3">
                                    @if($t->status==='pending')
                                        <form method="post" action="{{ route('tickets.approve', $t) }}" class="inline">
                                            @csrf
                                            <button class="px-3 py-1 bg-green-600 text-white rounded">Approve</button>
                                        </form>
                                        <form method="post" action="{{ route('tickets.reject', $t) }}" class="inline ms-2">
                                            @csrf
                                            <button class="px-3 py-1 bg-red-600 text-white rounded">Reject</button>
                                        </form>
                                    @else
                                        <span class="text-sm">{{ $t->moderator_note }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">{{ $tickets->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>