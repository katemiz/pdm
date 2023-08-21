<section class="section container">

    {{-- <x-title :title="$title" :subtitle="$subtitle" /> --}}

    @if (session()->has('message'))
        <div class="notification">
            {{ session('message') }}
        </div>
    @endif

    {{-- LISTING --}}
    @if ($isList)
        @include('admin.users.users-list')
    @endif

    {{-- FORM --}}
    @if ($isAdd || $isEdit)
        @include('admin.users.users-form')
    @endif

    {{-- VIEW --}}
    @if ($isView)
        @include('admin.users.users-view')
    @endif

</section>
