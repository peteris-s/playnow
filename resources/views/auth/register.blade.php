<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="relative" novalidate>
        @csrf

        <div class="space-y-4">
            <div>
                <x-text-input id="name" placeholder="Full name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-text-input id="email" placeholder="Email address" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-text-input id="password" placeholder="Password" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-text-input id="password_confirmation" placeholder="Confirm password" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-6 text-sm text-gray-400">
            <a href="{{ route('login') }}" class="hover:underline">{{ __('Already have an account?') }}</a>
            <span></span>
        </div>

        <!-- Floating circular submit button -->
        <button type="submit" class="absolute -bottom-8 right-6 w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white shadow-2xl transform hover:scale-105 transition floating-cta">
            <span class="text-xs font-bold">{{ __('Join') }}</span>
        </button>
    </form>
</x-guest-layout>
