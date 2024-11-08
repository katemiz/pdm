<div class="flex flex-col md:flex-row gap-4 sm:max-w-[400px] md:max-w-[480px] my-4 mx-auto">

    <div class="flex-1 w-full flex-col mx-auto p-4 shadow-lg rounded-lg bg-white">

        {{-- LANG LNKS --}}
        <div class="flex w-full justify-between">

            <div class="flex">
                <a href="{{config('appconstants.kapkara.link')}}">
                    <img src="{{asset('/images/baykus_orange.svg')}}" width="24px" alt="kapkara icon">
                </a>
            </div>

            <div class="flex">

                <a
                    wire:click="switchLang('tr')"
                    class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500 mr-2">
                TR
                </a>

                <a
                    wire:click="switchLang('en')"
                    class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500 ml-2">
                EN
                </a>

            </div>

        </div>

        {{-- EMAIL, PASSWORD AND SUBMIT --}}
        <div class="flex flex-col justify-between ">


            <p class="text-3xl font-extrabold pt-4">{{ config('appconstants.app.code') }}</p>
            <p class="text-gray-500">{{ config('appconstants.app.name') }}</p>


            <div class="mx-auto justify-center py-16">
                <x-carbon-model-alt class="w-36 h-36 text-indigo-500 my-4"/>
            </div>



            {{-- EMAIL --}}
            @if (in_array($action,['login','register','forgot']))
                <div class="mb-6">
                    <label for="label_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('ui.elements.email.label')}}</label>
                    <input type="email" name="email" id="label_email" wire:model="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('ui.elements.email.placeholder')}}">

                    @error('email')
                    <p class="mt-2 text-sm text-red-500 dark:text-gray-400">{{ $message }}</p>
                    @enderror

                </div>
            @endif


            {{-- PASSWORD --}}
            @if (in_array($action,['login']))
                <div class="mb-6">
                    <label for="label_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('ui.elements.password.label')}}</label>
                    <input type="password" name="password" id="label_password" wire:model="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('ui.elements.password.placeholder')}}">

                    @error('password')
                    <p class="mt-2 text-sm text-red-500 dark:text-gray-400">{{ $message }}</p>
                    @enderror

                </div>

                <a wire:click="changeAction('forgot')" class="text-center text-blue-600">{{__('ui.links.forgot.text')}}</a>

            @endif

            @if (in_array($action,['forgot']))
                <livewire:flash-message :msg="$msg">
            @endif





            @if (session('status'))

            {{ session('status') }}

            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif












            @if (in_array($action,['forgot']))
                <button wire:click="sendResetLink" type="button" class="px-5 mt-6 py-4 w-full text-base font-medium text-center text-white bg-gray-900 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{__('ui.links.reset.text')}}
                </button>
            @else
                <button wire:click="loginUsr" type="button" class="px-5 mt-6 py-4 w-full text-base font-medium text-center text-white bg-gray-900 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{__('ui.links.login.text')}}
                </button>
            @endif

        </div>

    </div>

    <div class="flex-1 hidden p-8 items-center justify-items-center bg-stone-300 shadow-lg rounded-lg">

        <div class="flex flex-col h-full justify-between" >
            <div class="text-6xl font-extrabold">{{config('appconstants.kapkara.motto')}}</div>
            <div class="mx-auto text-gray-50">
                <img src="{{asset('/images/baykus_orange.svg')}}" width="256px" alt="relax">
            </div>
        </div>

    </div>














</div>




