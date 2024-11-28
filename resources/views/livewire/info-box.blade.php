<div class="flex flex-col md:flex-row my-4">

    <div class="pr-6">
        <p class="uppercase tracking-wide text-sm text-indigo-500 ">ADDED</p>
        <p class="text-sm text-gray-500">{{ $author->email }}</p>
        <p class="text-sm text-gray-400">{{ $author->name }} {{ $author->lastname }}</p>
        <p class="text-sm text-gray-400">{{ $created_at }}</p>
    </div>

    <div class="pr-6">
        <p class="uppercase tracking-wide text-sm text-indigo-500 ">MODIFED</p>
        <p class="text-sm text-gray-500">{{ $modifier->email }}</p>
        <p class="text-sm text-gray-400">{{ $modifier->name }} {{ $modifier->lastname }}</p>
        <p class="text-sm text-gray-400">{{ $modified_at }}</p>

    </div>


    @if ($checker)
    <div class="pr-6">
        <p class="uppercase tracking-wide text-sm text-indigo-500 ">CHECKED</p>
        <p class="text-sm text-gray-500">{{ $checker->email }}</p>
        <p class="text-sm text-gray-400">{{ $checker->name }} {{ $checker->lastname }}</p>

        @if ($check_reviewed_at)
            <p class="text-sm text-gray-400">{{ $check_reviewed_at }}</p>
        @endif
    </div>
    @endif


    @if ($approver)
    <div class="pr-6">
        <p class="uppercase tracking-wide text-sm text-indigo-500 ">{{ Str::upper($status) }}</p>
        <p class="text-sm text-gray-500">{{ $approver->email }}</p>
        <p class="text-sm text-gray-400">{{ $approver->name }} {{ $approver->lastname }}</p>

        @if ($app_reviewed_at)
            <p class="text-sm text-gray-400">{{ $app_reviewed_at }}</p>
        @endif
    </div>
    @endif

    <div class="flex-grow text-right">
        <p class="uppercase tracking-wide text-sm text-indigo-500">STATUS</p>

        <p class="text-sm text-gray-400">{{ $status }}</p>
    </div>

    <div class="pl-6">
        <div class="card-image ">
            <figure class="image is-64x64  is-inline-block">
                {!! QrCode::size(64)->generate(url('/').config('conf_users.viewBtn.redirect').$id) !!}
            </figure>
        </div>
    </div>



</div>