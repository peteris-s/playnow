<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Create Game') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div id="game-create-form" class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('games.store') }}">
                    @csrf
                    <input type="hidden" name="timezone" id="browser-timezone" />

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Sport</label>
                            <select name="sport_type" id="sport-select" required class="mt-1 block w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Choose a sport</option>
                                @foreach(config('latvia_places.sports') as $s)
                                    <option value="{{ $s }}" @if(old('sport_type')==$s) selected @endif>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Location</label>
                            <input name="location" id="location-input" list="location-list" class="mt-1 block w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required placeholder="Type or choose a suggested location" />
                            <datalist id="location-list"></datalist>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Time</label>
                            <input name="game_time" type="datetime-local" required class="mt-1 block w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Max players</label>
                            <input name="max_players" type="number" value="10" required min="2" class="mt-1 block w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Notes</label>
                            <textarea name="notes" class="mt-1 block w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                        </div>

                        <div class="text-right">
                            <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">Create</button>
                        </div>
                    </div>
                </form>
                <script>
                    (function(){
                        try {
                            var tz = Intl.DateTimeFormat().resolvedOptions().timeZone || 'UTC';
                            var f = document.getElementById('browser-timezone');
                            if (f) f.value = tz;
                        } catch(e) {}
                    })();
                </script>
                <script>
                    (function(){
                        var places = @json(config('latvia_places.places'));
                        var sportSel = document.getElementById('sport-select');
                        var locInput = document.getElementById('location-input');
                        var datalist = document.getElementById('location-list');

                        function populateDatalist(sport) {
                            datalist.innerHTML = '';
                            if (sport && places[sport]) {
                                places[sport].forEach(function(place){
                                    var opt = document.createElement('option');
                                    opt.value = place;
                                    datalist.appendChild(opt);
                                });
                            }
                            var seen = new Set();
                            Object.keys(places).forEach(function(k){
                                places[k].forEach(function(p){
                                    if(!seen.has(p)){
                                        seen.add(p);
                                        var o=document.createElement('option');
                                        o.value=p;
                                        datalist.appendChild(o);
                                    }
                                });
                            });
                            var old = '{{ old("location") }}';
                            if (old && locInput) locInput.value = old;
                        }

                        if (sportSel) {
                            sportSel.addEventListener('change', function(){
                                populateDatalist(this.value);
                            });
                            populateDatalist(sportSel.value || null);
                        } else {
                            populateDatalist(null);
                        }
                    })();
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
