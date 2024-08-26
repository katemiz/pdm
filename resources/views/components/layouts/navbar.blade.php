<nav class="flex flex-col md:flex-row items-stretch bg-gray-800">


    <div class="flex bg-amber-300">

        {{-- APP LOGO --}}
        <a href="/" class="flex items-center space-x-3 ml-2 rtl:space-x-reverse text-orange-500 p-4">
        <x-carbon-model-alt class="w-8"/>
        <span class="font-bold text-lg">{{ config('appconstants.app.code') }}</span>
        </a>

    </div>






    <div class="flex-1 items-center text-white">

        {{-- MAIN MENU --}}
        <div class="items-center justify-between hidden w-full md:flex p-4" id="menu">

            <livewire:dropdown did='deneme' btitle='Admin' />




            @if(Auth::check())
            @role(['admin'])

            <div class="flex flex-row bg-sky-200">

                <button class="idAdminButton" type="button" class="inline-flex text-white items-center me-2">
                    <x-carbon-letter-aa class="w-6 h-6 mr-2 text-amber-500"/>
                    Admin
                </button>

                <!-- User Dropdown Menu -->
                <div id="adminMenu" class="z-50 hidden absolute bg-teal-300 top-[30px] right-0 my-4 text-base list-none divide-y divide-gray-100 rounded-lg shadow-lg">

                    <ul class="py-2">

                        <li>
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Change Password</a>
                        </li>

                        <li>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a :href="route('logout')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('ui.links.logout.text') }}
                            </a>
                        </form>
                        </li>

                    </ul>

                </div>

            </div>

            @endrole
            @endif

















            <ul class="flex flex-col md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0">

            <li>
                <a href="/" class="block py-2 px-3 md:bg-transparent hover:bg-gray-600 md:p-0 md:dark:text-blue-500" aria-current="page">Home</a>
            </li>

            <li>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Admin</a>
            </li>

            <li>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
            </li>

            <li>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Pricing</a>
            </li>

            <li class="relative">
                <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex relative items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                DropdownB <x-carbon-chevron-down class="w-5 h-5 me-2 pl-1" />
                </button>

                <!-- Dropdown menu -->
                <div id="dropdownNavbar" class="z-10 hidden absolute font-normal bg-white divide-y divide-gray-100 shadow w-44 dark:bg-gray-700 dark:divide-gray-600">

                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLargeButton">

                    <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                    </li>

                    <li aria-labelledby="dropdownNavbarLink" class="relative">

                    <button id="doubleDropdownButton" data-dropdown-toggle="doubleDropdown" data-dropdown-placement="right-start" type="button" class="flex items-center justify-between absolute w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        Dropdown <x-carbon-chevron-down class="w-4 h-4 me-2" />
                    </button>

                    <div id="doubleDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="doubleDropdownButton">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Overview</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">My downloads</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Billing</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Rewards</a>
                        </li>
                        </ul>
                    </div>

                    </li>

                    <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                    </li>

                </ul>

                <div class="py-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                </div>
                </div>

            </li>

            <li>
                <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
            </li>

            </ul>
        </div>

    </div>


    <div class="flex pr-2">
        {{-- USER MENU --}}
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse" >

            @if(Auth::check())

            <button id="userMenuButton" type="button" class="flex text-white" >
                <span>{{ Auth::user()->name }} {{ Auth::user()->lastname }}</span>
                <x-carbon-chevron-down class="w-5 h-5 me-2 pl-1" />
            </button>

            <!-- User Dropdown Menu -->
            <div id="userMenu" class="z-50 hidden absolute bg-teal-300 top-[30px] right-0 my-4 text-base list-none divide-y divide-gray-100 rounded-lg shadow-lg">

                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }} {{ Auth::user()->lastname }}</span>
                    <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                </div>

                <ul class="py-2">

                    <li>
                        <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Change Password</a>
                    </li>

                    <li>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a :href="route('logout')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('ui.links.logout.text') }}
                        </a>
                    </form>
                    </li>

                </ul>

            </div>

            @else
            <a href="/logware/login" type="button" class="text-white text-right inline-flex items-center me-2">
                <x-carbon-login class="w-6 h-6 mr-2"/>
                {{ __('ui.links.login.text')}}
            </a>
            @endif

        </div>
    </div>








</nav>





