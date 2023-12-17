<div class="columns">

    <div class="column">
        <a href='#'>
            <span class="icon "><x-carbon-chevron-left /></span>
        </a>
    </div>

    @role(['admin','company_admin','engineer'])
    <div class="column has-text-centered">
        <a wire:click='editPage({{ $pid }})'>
            <span class="icon "><x-carbon-edit /></span>
        </a>
        <a  wire:click="triggerDelete('document',{{ $uid }})">
            <span class="icon has-text-danger"><x-carbon-trash-can /></span>
        </a>   
    </div>
    @endrole

    <div class="column has-text-right">
        <a href='#'>
            <span class="icon "><x-carbon-chevron-right /></span>
        </a>
    </div>

</div>






<h2 class="subtitle has-text-weight-light">{{ $ptitle }}</h2>

        
<div class="content">
    {!! $pcontent !!}
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