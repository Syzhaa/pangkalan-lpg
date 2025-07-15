<section>
    <header>
        {{-- Header dengan style baru --}}
        <h2 class="text-lg font-medium text-slate-800">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Input untuk Nama --}}
        <div>
            <label for="name" class="block mb-1.5 text-sm font-medium text-slate-600">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="block w-full px-3 py-2 text-sm border border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input untuk Email --}}
        <div>
            <label for="email" class="block mb-1.5 text-sm font-medium text-slate-600">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="block w-full px-3 py-2 text-sm border border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-slate-700">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            {{-- Tombol Primary dengan style baru --}}
            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>