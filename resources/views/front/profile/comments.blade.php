<x-front-layout>
    <x-slot name="header">
        <a href="{{ route('profile.edit') }}"
            class="font-semibold text-lg text-gray-800 leading-tight border-2 border-emerald-200 px-2 py-1 rounded-full">
            {{ __('Profile') }}</a>
        <span style="display:inline-block; margin:0px 15px;"> | </span>
        <a href="{{ route('front.home') }}"
            class="font-semibold text-lg text-gray-800 leading-tight bg-emerald-200 px-2 py-1 rounded-full">
            {{ __('Dashboard') }}</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="px-4 sm:px-12 lg:px-12">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-xl font-semibold text-gray-900 "><span
                                        class="uppercase">{{ $validated['type'] }}</span> -
                                    {{ $data->noc_no ?? $data->uqlid }}</h1>
                            </div>
                        </div>
                        <div class="mt-8 flex flex-col">
                            <div class="mb-10">
                                <p><b>JB Comment</b></p>
                                <p>{!! $data->admin_comment !!}</p>
                            </div>

                            <hr>

                            <div class="my-10">
                                <p><b>Your Comment</b></p>
                                @if ($data->customer_comment)
                                    <p>{!! $data->customer_comment !!}</p>
                                @else
                                    <form action="{{ route('customer_comment.add') }}" method="post">
                                        @csrf
                                        <textarea required id="customer_comment" name="customer_comment"
                                            class="w-full border-gray-600 border-2 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 mb-2 block p-2"
                                            maxlength="1000" rows="5"></textarea>

                                        <input type="hidden" name="type" value="{{ $validated['type'] }}">
                                        <input type="hidden" name="slug" value="{{ $validated['slug'] }}">

                                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</x-front-layout>
