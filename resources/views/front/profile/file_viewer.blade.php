<x-front-layout>
    <x-slot name="header">
        <a href="{{ route('profile.edit') }}" class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </a>
        <span style="display:inline-block; margin:0px 15px;"> | </span>
        <a href="{{ route('front.home') }}" class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="px-4 sm:px-12 lg:px-12">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-xl font-semibold text-gray-900">Legal Documents</h1>
                            </div>
                        </div>
                        <div class="mt-8 flex flex-col">
                            <iframe height="1000" src="{{asset(asset_path('storage/upload/legaldoc/' . $document->doc_file))}}" frameborder="0"></iframe>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-front-layout>
