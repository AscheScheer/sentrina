<x-guest-layout>
    @if (Auth::guard('kepsek')->check())
    <div class="flex items-center justify-center mt-4">
        <p class="text-lg font-semibold">
            {{ __('Anda telah Login') }}
        </p>
    </div>
    <div class="flex items-center justify-center mt-4">
        <a href="{{ route('kepsek.dashboard') }}">
            <x-primary-button>
                {{ __('Go to Dashboard') }}
            </x-primary-button>
        </a>
    </div>
    @else
    <form method="POST" action="{{ route('kepsek.login.submit') }}">
        @csrf
        <div class="flex items-center text-center mb-4 font-bold text-xl">
            <p>Welcome Kepala Sekolah!</p>
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3 mt-2" role="alert">
            <strong>Email atau Password salah!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Log in as Kepala Sekolah') }}
            </x-primary-button>
        </div>
    </form>
    @endif
    <div class="mb-2 mt-2">
        <small>
            User biasa?
            <a href="/login" class="text-muted underline">Login disini</a>
            atau
            <a href="/staff/login" class="text-muted underline">Login Staff.</a>
        </small>
    </div>
</x-guest-layout>
