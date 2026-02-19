@if ($message = session('success'))
    <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        <div class="bg-green-600 text-white px-4 py-3 rounded-md shadow">{{ $message }}</div>
    </div>
@endif

@if ($message = session('info'))
    <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        <div class="bg-blue-600 text-white px-4 py-3 rounded-md shadow">{{ $message }}</div>
    </div>
@endif

@if ($message = session('error'))
    <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        <div class="bg-red-600 text-white px-4 py-3 rounded-md shadow">{{ $message }}</div>
    </div>
@endif

@if ($errors->any())
    <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        <div class="bg-red-700 text-white px-4 py-3 rounded-md shadow">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
