<section>
    <header>
        {{-- Header dengan style baru --}}
        <h2 class="text-lg font-medium text-slate-800">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Input untuk Current Password --}}
        <div>
            <label for="update_password_current_password" class="block mb-1.5 text-sm font-medium text-slate-600">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="block w-full px-3 py-2 text-sm border border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input untuk New Password --}}
        <div>
            <label for="update_password_password" class="block mb-1.5 text-sm font-medium text-slate-600">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="block w-full px-3 py-2 text-sm border border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="new-password">
            @error('password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input untuk Confirm Password --}}
        <div>
            <label for="update_password_password_confirmation" class="block mb-1.5 text-sm font-medium text-slate-600">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full px-3 py-2 text-sm border border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            {{-- Tombol Primary dengan style baru --}}
            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
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