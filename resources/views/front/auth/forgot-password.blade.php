<x-front-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your phone number and we will sent you a OTP to reset password.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="phone" name="phone" :value="old('phone')" required autofocus />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div> --}}

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Sent Password Reset Email') }}
            </x-primary-button>
        </div>
    </form>
</x-front-guest-layout>
