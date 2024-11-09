
@props(['name' => false])


@switch($slot)



    @case('Admin')
        <x-carbon-credentials class="w-6 text-blue-600 md:text-amber-400"/>
        @break

    @case('Users')
        <x-carbon-user-multiple class="w-6"/>
        @break

    @case('Roles')
        <x-carbon-person class="w-6"/>
        @break

    @case('Permissions')
        <x-carbon-password class="w-6"/>
        @break


    @case('Companies')
        <x-carbon-building class="w-6"/>
        @break


    @case('Projects')
        <x-carbon-business-processes class="w-6"/>
        @break

    {{-- ************* --}}
    @case('Requests')
        <x-carbon-intent-request-scale-in class="w-6 text-blue-600 md:text-amber-400"/>
        @break

    @case('Change Requests')
        <x-carbon-change-catalog class="w-6"/>
        @break


    @case('Engineering Change Requests (ECN)')
        <x-carbon-scis-control-tower class="w-6"/>
        @break


    {{-- ************* --}}
    @case('Products')
        <x-carbon-industry class="w-6 text-blue-600 md:text-amber-400"/>
        @break


    @case('Sellables')
        <x-carbon-box class="w-6"/>
        @break


    @case('Components')
        <x-carbon-radio class="w-6"/>
        @break


    {{-- ************* --}}
    @case('Engineering')
        <x-carbon-function-math class="w-6 text-blue-600 md:text-yellow-400"/>
        @break

    @case('Engineering Utilities')
        <x-carbon-sigma class="w-6"/>
        @break

    @case('Materials')
        <x-carbon-cube class="w-6"/>
        @break


    @case('Product Notes')
        <x-carbon-pen-fountain class="w-6"/>
        @break

    @case('Standard Families')
        <x-carbon-catalog class="w-6"/>
        @break




    {{-- ************* --}}


















    @case('Documents')
        <x-carbon-document-attachment class="w-6 text-blue-600 md:text-yellow-400"/>
        @break

    {{-- ************* --}}

    @case('MOM')
        <x-carbon-report-data class="w-6 text-blue-600 md:text-yellow-400"/>
        @break








        @break
    @default

@endswitch
