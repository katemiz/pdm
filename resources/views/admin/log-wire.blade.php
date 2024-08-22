<section class="section w-full md:w-1/2  md:m-8 mx-auto">


    <div class="flex justify-between my-4 w-full">

        <div>
            <a href="{{config('constants.company.link')}}">
                <img src="{{asset('/images/baykus_orange.svg')}}" width="24px" alt="{{config('appconstants.kapkara.name')}}">
            </a>
        </div>

        <div>
            <a wire:click="switchLang('tr')" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500 mr-2" href="#">
            TR
            </a>

            <a wire:click="switchLang('en')" class="inline-flex flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500 ml-2" href="#">
            EN
            </a>
        </div>
    </div>



    <div class="shadow-lg w-full bg-white p-4">



        <div class="box">

            <p class="text-4xl font-bold">{{ config('appconstants.app.code') }}</p>
            <p class="text-gray-500">{{ config('appconstants.app.name') }}</p>


            <div class="flex mx-auto justify-center">
                <x-carbon-model-alt class="w-38 h-48 text-red"/>
            </div>


            {{-- EMAIL --}}
            @if (in_array($action,['login','register','forgot']))
            <div>
                <label class="font-semibold text-gray-600 my-14" for="email">{{__('ui.elements.email.label')}}</label>
                <div class="flex flex-wrap items-stretch w-full mb-4 relative">
                    <input
                        class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 p-3 relative focus:border-blue focus:shadow"
                        type="email"
                        name="email"
                        wire:model="email"
                        placeholder="{{__('ui.elements.email.placeholder')}}" required >
                </div>
                @error('email')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
            @endif

            @if ($action ==='forgot')

            <div class="notification is-info is-light">
                <p class="subtitle">{{ __('ui.links.forgot.text' )}}</p>
                <p>{{ __('ui.links.forgot.info' )}}</p>
            </div>

            @endif



            {{-- NAME, LASTNAME --}}
            @if (in_array($action,['register']))
            <div class="columns">
                <div class="column field is-half">
                    <label class="label has-text-weight-light" for="email">{{__('ui.elements.name.label')}}</label>
                    <div class="control has-icons-right">
                        <input
                            class="input"
                            type="text"
                            name="name"
                            wire:model="name"
                            placeholder="{{__('ui.elements.name.placeholder')}}" required >
                    </div>
                </div>

                <div class="column field">
                    <label class="label has-text-weight-light" for="email">{{__('ui.elements.lastname.label')}}</label>
                    <div class="control has-icons-right">
                        <input
                            class="input"
                            type="text"
                            name="lastname"
                            wire:model="lastname"
                            placeholder="{{__('ui.elements.lastname.placeholder')}}" required >
                    </div>
                </div>
            </div>
            @endif


            {{-- PASSWORD --}}
            @if (in_array($action,['login']))
            <div class="field">

                <label class="font-semibold text-gray-600" for="email">{{__('ui.elements.password.label')}}</label>
                <div class=" border-y-gray-300 p-4">

                    <input
                        class="input"
                        type="password"
                        name="password"
                        wire:model="password"
                        placeholder="{{__('ui.elements.password.placeholder')}}" required >
                </div>

                @error('password')
                <p class="help is-danger">{{ $message }}</p>
                @enderror

            </div>
            @endif

            {{-- CURRENT PASSWORD --}}
            @if (in_array($action,['change']))
            <div class="field">

                <label class="label has-text-weight-light" for="email">{{__('ui.elements.cur_password.label')}}</label>
                <div class="control has-icons-right">

                    <input
                        class="input"
                        type="password"
                        name="cur_password"
                        wire:model="cur_password"
                        placeholder="{{__('ui.elements.cur_password.placeholder')}}" required >
                </div>

            </div>
            @endif


            {{-- PASSWORD,CONFIRM PASSWORD, NEW PASSWORD --}}

            @if (in_array($action,['register','reset','change']))

            <div class="columns">
                <div class="column field is-half">

                    @if ($action === 'change')
                        <label class="label has-text-weight-light" for="email">{{__('ui.elements.npassword.label')}}</label>

                        <div class="control has-icons-right">

                            <input
                                class="input"
                                type="password"
                                name="npassword"
                                wire:model="npassword"
                                placeholder="{{__('ui.elements.npassword.placeholder')}}" required >
                        </div>
                    @else
                        <label class="label has-text-weight-light" for="email">{{__('ui.elements.password.label')}}</label>

                        <div class="control has-icons-right">

                            <input
                                class="input"
                                type="password"
                                name="password"
                                wire:model="password"
                                placeholder="{{__('ui.elements.password.placeholder')}}" required >
                        </div>
                    @endif
                </div>

                <div class="column field">

                    <label class="label has-text-weight-light" for="email">{{__('ui.elements.cpassword.label')}}</label>

                    <div class="control has-icons-right">

                        <input
                            class="input"
                            type="password"
                            name="cpassword"
                            wire:model="cpassword"
                            placeholder="{{__('ui.elements.cpassword.placeholder')}}" required >
                    </div>

                </div>
            </div>
            @endif


            @if (in_array($action,['login']))
            <button wire:click="loginUsr" class="button is-link mt-6 is-fullwidth">{{__('ui.links.login.text')}}</button>
            @endif

            @if (in_array($action,['register']))
            <button wire:click="registerUsr" class="button is-link mt-6 is-fullwidth">{{__('ui.links.register.text')}}</button>
            @endif

            @if (in_array($action,['forgot']))
            <button wire:click="sendResetLink" class="button is-link mt-6 is-fullwidth">{{__('ui.links.forgot.resetlink')}}</button>
            @endif

            @if (in_array($action,['reset']))
            <button wire:click="resetPwd" class="button is-link mt-6 is-fullwidth">{{__('ui.links.reset.text')}}</button>
            @endif

            @if (in_array($action,['change']))
            <button wire:click="changePwd" class="button is-link mt-6 is-fullwidth">{{__('ui.links.change.text')}}</button>
            @endif

        </div>

        <nav class="level">
            <!-- Left side -->
            <div class="level-left">
                {{-- <a href="{{config('constants.company.link')}}">
                    <img src="{{asset('/images/baykus_orange.svg')}}" width="24px" alt="{{config('appconstants.kapkara.name')}}">
                </a> --}}
            </div>

            <nav class="breadcrumb has-bullet-separator is-right level-right" aria-label="breadcrumbs">
                <p class="has-text-right is-size-6 has-text-weight-light my-0">

                    {{-- @if (in_array($action,['login','forgot','change']))
                    <a wire:click="changeAction('register')" class="px-0">{{__('ui.links.register.text')}}</a>
                    @endif --}}

                    @if (in_array($action,['register']))
                    <a wire:click="changeAction('login')" class="px-0">{{__('ui.links.login.text')}}</a>
                    @endif

                </p>
            </nav>

        </nav>



    </div>



    {{-- <a wire:click="changeAction('reset')" class="px-0">reset</a>
    <a wire:click="changeAction('change')" class="px-0">change</a> --}}



</section>









