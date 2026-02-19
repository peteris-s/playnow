<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Profile banner</label>
            @if($user->profile_banner_path)
                <div class="mt-2 mb-2">
                    <img src="{{ asset('storage/'.$user->profile_banner_path) }}" alt="Banner" class="w-full h-32 object-cover rounded" />
                </div>
            @endif
            <input type="file" name="profile_banner" accept="image/*" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_banner')" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Profile photo</label>
            @if($user->profile_photo_path)
                <div class="mt-2 mb-2">
                    <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Avatar" class="w-20 h-20 object-cover rounded-full" />
                </div>
            @endif
            <input type="file" name="profile_photo" accept="image/*" class="mt-1 block" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full" maxlength="1000">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="mt-4">
            <x-input-label for="city" :value="__('City')" />
            <select id="city" name="city" class="mt-1 block w-full">
                <option value="">Choose your city</option>
                @foreach(config('latvia_cities.cities') as $c)
                    <option value="{{ $c }}" @if(old('city', $user->city)==$c) selected @endif>{{ $c }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div class="mt-4">
            <x-input-label for="age_group" :value="__('Age group')" />
            <select id="age_group" name="age_group" class="mt-1 block w-full">
                @php $ages = ['Under 18','18-24','25-34','35-44','45+']; @endphp
                <option value="">Prefer not to say</option>
                @foreach($ages as $a)
                    <option value="{{ $a }}" @if(old('age_group', $user->age_group)==$a) selected @endif>{{ $a }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('age_group')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="real_name" :value="__('Real name')" />
            <x-text-input id="real_name" name="real_name" type="text" class="mt-1 block w-full" :value="old('real_name', $user->real_name)" required autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('real_name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
