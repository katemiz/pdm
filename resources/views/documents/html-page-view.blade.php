@if (session()->has('info'))
<div class="notification is-info is-light">
    {{ session('info') }}
</div>
@endif

<div class="columns">

    <div class="column">

        @if ($pnode_id > 0)

        <a href='javascript:viewPreviuosNext({{ $pnode_id }})'>
            <span class="icon "><x-carbon-chevron-left /></span>
        </a>
        @endif

    </div>

    @role(['admin','company_admin','engineer'])
    <div class="column has-text-centered">
        <a wire:click='editPage({{ $page->id }})'>
            <span class="icon "><x-carbon-edit /></span>
        </a>
        <a  wire:click="triggerDelete('page',{{ $page->id }})">
            <span class="icon has-text-danger"><x-carbon-trash-can /></span>
        </a>
    </div>
    @endrole

    <div class="column has-text-right">
        @if ($nnode_id > 0)
        <a href='javascript:viewPreviuosNext({{ $nnode_id }})'>
            <span class="icon "><x-carbon-chevron-right /></span>
        </a>
        @endif
    </div>

</div>









<h2 class="subtitle has-text-weight-light">{{ $page->title }}</h2>


<div class="content">
    {!! $page->content !!}
</div>

<div class="columns is-size-7 has-text-grey mt-6">

    <div class="column">
        <p>{{ $pcreated_by }}</p>
        <p>{{ $pcreated_at }}</p>
    </div>



    <div class="column has-text-right">
        <p>{{ $pupdated_by }}</p>
        <p>{{ $pupdated_at }}</p>
    </div>

</div>


{{-- <script>
    RefreshPreviousNext({{ $page->id }})
</script> --}}
