<x-front-layout>
    <x-slot name="header">
        <span class="font-semibold text-lg text-gray-800 leading-tight bg-emerald-200 px-2 py-1 rounded-full">
            {{ __('Profile') }}</span>
        <span style="display:inline-block; margin:0px 15px;"> | </span>
        <a href="{{route('dashboard')}}" class="font-semibold text-lg text-gray-800 leading-tight border-2 border-emerald-200 px-2 py-1 rounded-full">
            {{ __('Dashboard') }}</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('front.profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('front.profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg hidden">
                <div class="max-w-xl">

                </div>
            </div>
        </div>
    </div>
</x-front-layout>