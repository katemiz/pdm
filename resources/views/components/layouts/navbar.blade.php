<header class="bg-gray-800 text-white border-b-2 border-blue-50">

  <nav class="flex items-center justify-between gap-4 px-4 py-4 h-16">

    <a href="/" class="text-2xl whitespace-nowrap flex ">
      <x-carbon-model-alt class="w-8 text-blue-600"/>
      <span class="px-2 font-extrabold">{{ config('appconstants.app.code') }}</span>
    </a>

    <div id="menu" class="absolute left-0 top-16 max-md:bg-gray-200 w-full flex flex-col gap-6 p-4 md:static md:flex-row md:justify-between items-center ">

        <ul class="flex flex-col text-black md:flex-row px-2 w-full z-50">

          {{-- ADMIN MENU --}}
          <li class="relative p-2 md:text-white justify-center md:hover:bg-sky-900">

            <x-nav-link id="admBtn" type="dropdown">Admin</x-nav-link>

            <div id="adminMenu" class="md:absolute mt-4 md:hidden flex flex-col bg-white w-full md:w-64 left-0 md:shadow-lg md:border md:border-gray-800">

              <ul class="flex flex-col text-black">

                <x-nav-link href="/usrs" type="submenu">Users</x-nav-link>
                <x-nav-link href="/docs" type="submenu">Roles</x-nav-link>
                <x-nav-link href="/document/list" type="submenu">Permissions</x-nav-link>
                <x-nav-link href="/document/list" type="submenu">Companies</x-nav-link>
                <x-nav-link href="/document/list" type="submenu">Projects</x-nav-link>

              </ul>
            </div>

          </li>



          {{-- REQUESTS MENU --}}
          <li class="relative p-2 md:text-white justify-center md:hover:bg-sky-900">

            <x-nav-link id="reqBtn" type="dropdown">Requests</x-nav-link>

            <div id="requestMenu" class="md:absolute mt-4 md:hidden flex flex-col bg-white w-full md:w-96 left-0 md:shadow-lg md:border md:border-gray-800">

              <ul class="flex flex-col text-black">

                <x-nav-link href="/document/list" type="submenu">Change Requests</x-nav-link>
                <x-nav-link href="/document/list" type="submenu">Engineering Change Requests (ECN)</x-nav-link>

              </ul>
            </div>

          </li>



          {{-- PRODUCTS MENU --}}
          <li class="relative p-2 md:text-white justify-center md:hover:bg-sky-900">

            <x-nav-link id="productsBtn" type="dropdown">Products</x-nav-link>

            <div id="productMenu" class="md:absolute mt-4 md:hidden flex flex-col bg-white w-full md:w-64 left-0 md:shadow-lg md:border md:border-gray-800">

                <ul class="flex flex-col text-black">

                    <x-nav-link href="/document/list" type="submenu">Sellables</x-nav-link>
                    <x-nav-link href="/document/list" type="submenu">Components</x-nav-link>

                </ul>
            </div>

          </li>



          {{-- DOCUMENTS --}}
          <x-nav-link href="/docs" type="menu_link" :active="request()->is('/documents')">Documents</x-nav-link>


          {{-- ENGINEERING MENU --}}
          <li class="relative p-2 md:text-white justify-center md:hover:bg-sky-900">

            <x-nav-link id="engBtn" type="dropdown">Engineering</x-nav-link>

            <div id="engineeringMenu" class="md:absolute mt-4 md:hidden flex flex-col bg-white w-full md:w-72 left-0 md:shadow-lg md:border md:border-gray-800">

                <ul class="flex flex-col text-black">

                    <x-nav-link href="/utilities" type="submenu">Engineering Utilities</x-nav-link>
                    <x-nav-link href="/materials" type="submenu">Materials</x-nav-link>
                    <x-nav-link href="/notes" type="submenu">Product Notes</x-nav-link>
                    <x-nav-link href="/standards" type="submenu">Standard Families</x-nav-link>

                </ul>
            </div>

          </li>

          {{-- MOM --}}
          <x-nav-link href="/mom" type="menu_link" :active="request()->is('/mom')">MOM</x-nav-link>

        </ul>



        {{-- USER MENU : LOGIN/LOGOUT --}}
        <div class="flex flex-col items-center md:flex-row">

          @if(Auth::check())

            <button id="usrButton" class="inline-flex items-center text-slate-50">
              <span class="px-2 whitespace-nowrap">{{ Auth::user()->name }} {{ Auth::user()->lastname }}</span>
              <x-carbon-chevron-down class="w-5"/>
            </button>

            <div id="usrMenu" class="md:absolute mt-4 md:hidden flex flex-col bg-gray-50 w-full md:w-48 right-0 shadow-lg md:border md:border-gray-800">

              <ul class="flex flex-col">

                <li class="hover:bg-gray-800 hover:text-white w-full pl-4 py-2 bg-gray-100 text-black md:pl-2">

                  <a href="/profile" class="inline-flex items-center">
                    <div class="text-blue-600">
                      <x-carbon-password class="w-6"/>
                    </div>
                    <span class="px-2 whitespace-nowrap">Change Password</span>
                  </a>

                </li>

                <li class="hover:bg-gray-800 hover:text-white w-full pl-4 py-2 bg-gray-100 text-black md:pl-2">

                  <form method="POST" action="{{ route('logout') }}">
                  @csrf
                    <button :href="route('logout')" class="inline-flex items-center">
                      <div class="text-blue-600">
                        <x-carbon-logout class="w-6"/>
                      </div>
                      <span class="px-2 whitespace-nowrap">{{ __('ui.links.logout.text') }}</span>
                    </button>
                  </form>

                </li>

              </ul>
            </div>

          @else

            <a href="/logware/login" class="inline-flex items-center bg-blue-400 md:bg-transparent w-full p-4">
              <div class="text-blue-600 md:text-yellow-400 ">
                <x-carbon-login class="w-6"/>
              </div>
              <span class="px-2">{{ __('ui.links.login.text')}}</span>
            </a>

          @endif

        </div>

    </div>

    <div id="hamburger" class="flex flex-col items-center gap-8 md:hidden">
        <x-carbon-menu class="w-6"/>
    </div>


  </nav>

  <script>


    // HAMBURGER MENU
    const hamburger = document.getElementById('hamburger')
    const menu = document.getElementById('menu')

    hamburger.addEventListener('click', () => {
      menu.classList.toggle('top-16')
      menu.classList.toggle('hidden')
    })


    // ADMIN MENU
    const adminButton = document.getElementById('admBtn')
    const adminMenu = document.getElementById('adminMenu')

    adminButton.addEventListener('click', () => {
      adminMenu.classList.toggle('md:hidden')
      adminMenu.classList.toggle('top-8')
    })

    adminMenu.addEventListener('mouseleave', () => {
      adminMenu.classList.toggle('md:hidden')
      adminMenu.classList.toggle('top-8')
    })


    // REQUESTS MENU
    const requestButton = document.getElementById('reqBtn')
    const requestMenu = document.getElementById('requestMenu')

    requestButton.addEventListener('click', () => {
      requestMenu.classList.toggle('md:hidden')
      requestMenu.classList.toggle('top-8')
    })

    requestMenu.addEventListener('mouseleave', () => {
      requestMenu.classList.toggle('md:hidden')
      requestMenu.classList.toggle('top-8')
    })


    // PRODUCTS MENU
    const productButton = document.getElementById('productsBtn')
    const productMenu = document.getElementById('productMenu')

    productButton.addEventListener('click', () => {
      productMenu.classList.toggle('md:hidden')
      productMenu.classList.toggle('top-8')
    })

    productMenu.addEventListener('mouseleave', () => {
      productMenu.classList.toggle('md:hidden')
      productMenu.classList.toggle('top-8')
    })


    // ENGINEERING MENU
    const engineeringButton = document.getElementById('engBtn')
    const engineeringMenu = document.getElementById('engineeringMenu')

    engineeringButton.addEventListener('click', () => {
      engineeringMenu.classList.toggle('md:hidden')
      productMenu.classList.toggle('top-8')
    })

    engineeringMenu.addEventListener('mouseleave', () => {
      engineeringMenu.classList.toggle('md:hidden')
      engineeringMenu.classList.toggle('top-8')
    })


    // USER MENU
    const usrButton = document.getElementById('usrButton')
    const usrMenu = document.getElementById('usrMenu')


    if (usrMenu != null) {

      usrButton.addEventListener('click', () => {
        usrMenu.classList.toggle('md:hidden')
        usrMenu.classList.toggle('top-8')
      })

      usrMenu.addEventListener('mouseleave', () => {
        usrMenu.classList.toggle('md:hidden')
        usrMenu.classList.toggle('top-8')
      })
    }







</script>


</header>




