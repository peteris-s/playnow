<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Create Game') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div id="game-create-form" class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <style>
                    /* Force readable text for native selects/options and inputs across browsers */
                    #game-create-form select,
                    #game-create-form input,
                    #game-create-form textarea {
                        color: #000 !important;
                        -webkit-text-fill-color: #000 !important; /* Safari/Chrome */
                        background: #fff !important;
                    }

                    /* Make option text readable and ensure white background in dropdown */
                    #game-create-form select option {
                        color: #000 !important;
                        background: #fff !important;
                    }

                    /* Highlighted/selected option in dropdown: use a slightly darker background so text remains visible */
                    #game-create-form select option:hover,
                    #game-create-form select option:active,
                    #game-create-form select option:checked {
                        background: #cfe8ff !important; /* light blue that contrasts with black text */
                        color: #000 !important;
                    }

                   
                    #game-create-form ::-webkit-input-placeholder { color: #666 !important; }
                    #game-create-form :-ms-input-placeholder { color: #666 !important; }
                    #game-create-form ::placeholder { color: #666 !important; opacity: 1; }
                </style>
                <form method="POST" action="{{ route('games.store') }}">
                    @csrf
                    <input type="hidden" name="timezone" id="browser-timezone" />

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Sport</label>
                            <select name="sport_type" id="sport-select" required class="mt-1 block w-full text-black" style="color:#000;">
                                <option value="">Choose a sport</option>
                                @foreach(config('latvia_places.sports') as $s)
                                    <option value="{{ $s }}" @if(old('sport_type')==$s) selected @endif>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Location</label>
                            <!-- Use an input + datalist so users can type and the browser will suggest matching locations -->
                            <input name="location" id="location-input" list="location-list" class="mt-1 block w-full text-black" style="color:#000;" required placeholder="Type or choose a suggested location" />
                            <datalist id="location-list"></datalist>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Time</label>
                            <input name="game_time" type="datetime-local" required class="mt-1 block w-full text-black" style="color:#000;" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Max players</label>
                            <input name="max_players" type="number" value="10" required min="2" class="mt-1 block w-full text-black" style="color:#000;" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Notes</label>
                            <textarea name="notes" class="mt-1 block w-full text-black" style="color:#000;"></textarea>
                        </div>

                        <div class="text-right">
                            <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">Create</button>
                        </div>
                    </div>
                </form>
                <script>
                    // Fill the hidden timezone input so the server can interpret the datetime-local value
                    (function(){
                        try {
                            var tz = Intl.DateTimeFormat().resolvedOptions().timeZone || 'UTC';
                            var f = document.getElementById('browser-timezone');
                            if (f) f.value = tz;
                        } catch(e) {
                            // ignore
                        }
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

                            // If a sport is chosen, show its curated places first
                            if (sport && places[sport]) {
                                places[sport].forEach(function(place){
                                    var opt = document.createElement('option');
                                    opt.value = place;
                                    datalist.appendChild(opt);
                                });
                            }

                            // Also add a broader list of city+venue suggestions so typing keywords works across cities
                            // Build a deduped map of all places across sports
                            var seen = new Set();
                            Object.keys(places).forEach(function(k){
                                places[k].forEach(function(p){ if(!seen.has(p)){ seen.add(p); var o=document.createElement('option'); o.value=p; datalist.appendChild(o); } });
                            });

                            // restore old value if present
                            var old = '{{ old("location") }}';
                            if (old && locInput) locInput.value = old;
                        }

                        if (sportSel) {
                            sportSel.addEventListener('change', function(){
                                populateDatalist(this.value);
                            });
                            // on page load, populate if sport pre-chosen
                            populateDatalist(sportSel.value || null);
                        } else {
                            // if no sport select found, still populate a unified list
                            populateDatalist(null);
                        }

                        // Optional: simple client-side filtering as user types to show matching suggestions
                        // Browsers already filter datalist matches, so we rely on that and allow free-text entry.
                    })();
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
