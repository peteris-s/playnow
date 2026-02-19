<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="relative" novalidate>
        @csrf

        <div class="space-y-4">
            <div>
                <x-text-input id="email" placeholder="Email address" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-text-input id="password" placeholder="Password" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center text-sm text-gray-400">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-600 bg-gray-900 text-indigo-500 focus:ring-indigo-400" name="remember">
                    <span class="ml-2">{{ __('Remember me') }}</span>
                </label>

                <div class="flex space-x-4 items-center">
                    <a class="text-sm text-gray-400 hover:underline" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-400 hover:underline" href="{{ route('password.request') }}">{{ __('Forgot?') }}</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Floating circular submit button -->
        <button type="submit" class="absolute -bottom-8 right-6 w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white shadow-2xl transform hover:scale-105 transition floating-cta">
            <span class="text-xs font-bold">{{ __('Log') }}<br>{{ __('In') }}</span>
        </button>
    </form>
</x-guest-layout>
