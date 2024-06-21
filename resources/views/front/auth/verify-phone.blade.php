<x-front-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your phone number. If you didn\'t receive the OTP, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification OTP has been sent to the phone number you provided during registration.') }}
        </div>
    @endif

    <x-alert />

    <div class="mt-4 flex items-start justify-between">

        <form method="POST" action="{{ route('customer.verifyPhoneSubmit') }}">
            @csrf
            <input type="hidden" name="user_phone" value="{{ $userPhone }}">
            <div>
                <x-input-label for="otp" :value="__('Enter OTP')" />
                <x-text-input id="otp" class="block mt-1 w-full" type="otp" name="otp" :value="old('otp')"
                    required autofocus />
                <x-input-error :messages="$errors->get('otp')" class="mt-2" />
            </div>



            <button type="submit"
                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 mt-5">
                {{ __('Submit') }}
            </button>
        </form>


        <div class="mt-4">
            <form action="{{route('customer.resendOtp')}}" method="post">
                @csrf
                <input type="hidden" name="user_phone" value="{{ $userPhone }}">
                <button class="text-blue-700 disabled:text-gray-600" id="resendOtpBtn" type="submit" disabled>Resend OTP again</button>
            </form>
            in <span id="otpTimer"></span>
        </div>

        {{-- <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification OTP') }}
                </x-primary-button>
            </div>
        </form> --}}


    </div>

    <script>
        function startTimer(duration, display) {
            var timer = duration,
                minutes, seconds;
            var myTimer = setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(myTimer);
                    document.getElementById("resendOtpBtn").disabled = false;
                    // timer = duration;
                }
            }, 1000);
        }

        window.onload = function() {
            var fiveMinutes = 60 * 0.2,
                display = document.querySelector('#otpTimer');
            startTimer(fiveMinutes, display);
        };
    </script>


</x-front-guest-layout>
