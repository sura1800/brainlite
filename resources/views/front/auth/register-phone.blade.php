<x-front-guest-layout>
    {{-- <x-alert /> --}}
    <h2 style="text-align:center; font-weight:bold; font-size:18px;text-decoration: underline;">Registration</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-2">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 gap-y-2 sm:grid-cols-4 sm:gap-x-4">
            <div class="mt-2 sm:col-span-2">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"
                    required autofocus maxlength="15" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            <div class="mt-2 sm:col-span-2" id="sendotpbox">
                <button id="sendOtp" type="button"
                    class="bg-green-600 hover:bg-green-700 text-white py-1 px-4 mt-[25px] border border-green-700 rounded-full  disabled:opacity-50">
                    Send OTP
                </button>
            </div>

            <div class="mt-1 sm:col-span-4" id="resendOtpBtnBox" style="display: none">
                Resend OTP again in <span id="otpTimer"></span>
            </div>

            <div class="mt-2 sm:col-span-2 otpbox" style="display: none">
                <x-input-label for="otp" :value="__('OTP')" />
                <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" :value="old('otp')"
                    autofocus maxlength="6" />
            </div>
            <div class="mt-2 sm:col-span-2 otpbox" style="display: none">
                <button id="verifyOtp" type="button"
                    class="bg-green-600 hover:bg-green-700 text-white py-1 px-4 mt-[25px] border border-green-700 rounded-full">
                    Verify OTP
                </button>
            </div>

            <div class="verifiedOtpMsg"></div>
        </div>

        <div class="mt-2">
            <x-input-label for="aadhaar" :value="__('Aadhaar/UIDAI')" />
            <x-text-input id="aadhaar" class="block mt-1 w-full" type="text" name="aadhaar" :value="old('aadhaar')"
                required autofocus maxlength="15" />
            <x-input-error :messages="$errors->get('aadhaar')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-2">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-2">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-2">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4" id="submitRegister">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    @push('scripts')
        <script>
            $(document).ready(function() {

                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                $("#sendOtp").on("click", function() {
                    let phoneNumber = $("#phone").val();
                    if (phoneNumber.trim() === "" || phoneNumber.trim() === null || phoneNumber.trim()
                        .length !== 10) {
                        toastr.error("Please enter a proper phone number to get OTP.");
                    } else {
                        // console.log(phoneNumber);

                        $.ajax({
                            url: "{{ route('customer.send_reg_otp') }}",
                            method: 'POST',
                            data: {
                                'phoneNo': phoneNumber,
                                '_token': "{{ csrf_token() }}",
                            },
                            dataType: "json",
                            success: function(response) {
                                console.log(response);
                                if (!response.error) {
                                    toastr.success(response.msg);

                                    if (response.data == 1) {
                                        $("#sendotpbox").html('');
                                        $("#sendotpbox").html(
                                            `<p class="mt-[28px]"><span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-4 py-2 rounded-full">Verified</span></p>`
                                        );
                                        $("#submitRegister").removeAttr('disabled')
                                    } else {
                                        $("#sendOtp").attr('disabled', 'disabled');
                                        $(".otpbox").show();
                                        $("#resendOtpBtnBox").show("500", function() {
                                            var fiveMinutes = 60 * 0.2,
                                                display = document.querySelector(
                                                    '#otpTimer');
                                            startTimer(fiveMinutes, display);
                                        });
                                    }


                                } else {
                                    toastr.error(response.msg);
                                }
                            }

                        });
                    }

                })

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
                            // document.getElementById("resendOtpBtn").disabled = false;
                            document.getElementById("sendOtp").disabled = false;
                            // timer = duration;
                        }
                    }, 1000);
                }

                $("#verifyOtp").on("click", function() {

                    let otpEntered = $("#otp").val();
                    let phoneNumber = $("#phone").val();
                    if (phoneNumber.trim() === "" || phoneNumber.trim() === null || phoneNumber.trim()
                        .length !== 10) {
                        toastr.error("Please enter a proper phone number to get OTP.");
                    }
                    if (otpEntered.trim() === "" || otpEntered.trim() === null || otpEntered.trim()
                        .length !== 6) {
                        toastr.error("Invalid OTP entered.");
                    } else {
                        // console.log(otpEntered);

                        $.ajax({
                            url: "{{ route('customer.verify_reg_otp') }}",
                            method: 'POST',
                            data: {
                                'otp': otpEntered,
                                'phoneNo': phoneNumber,
                                '_token': "{{ csrf_token() }}",
                            },
                            dataType: "json",
                            success: function(response) {
                                console.log(response);
                                if (!response.error) {
                                    toastr.success(response.msg);
                                    // $("#sendOtp").attr('disabled', 'disabled');
                                    $(".otpbox").hide();
                                    $("#resendOtpBtnBox").hide();
                                    $("#sendotpbox").html('');
                                    $("#sendotpbox").html(
                                        `<p class="mt-[28px]"><span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-4 py-2 rounded-full">Verified</span></p>`
                                    );
                                    $("#submitRegister").removeAttr('disabled');
                                } else {
                                    toastr.error(response.msg);
                                }
                            }

                        });
                    }

                })

                // window.onload = function() {
                //     var fiveMinutes = 60 * 0.2,
                //         display = document.querySelector('#otpTimer');
                //     startTimer(fiveMinutes, display);
                // };

            });
        </script>
    @endpush
</x-front-guest-layout>
