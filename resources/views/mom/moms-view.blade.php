
<div class="columns">

    <div class="column">
        <header class="mb-6">
            <h1 class="title has-text-weight-light is-size-1">MOM</h1>
            <h2 class="subtitle has-text-weight-light">Minutes of Meetings</h2>
        </header>
    </div>
    <div class="column is-2">
        <figure class="image is-fluid">
            <img src="{{ asset('/images/mom.svg') }}">
        </figure>
    </div>
</div>



@if (session()->has('message'))
    <div class="notification">
        {{ session('message') }}
    </div>
@endif

<div class="card">

    <div class="card-content">

        <nav class="level mb-6">
            <!-- Left side -->
            <div class="level-left">

                <p class="level-item">
                    <a href="/moms/list">
                        <span class="icon is-small"><x-carbon-table /></span>
                        <span>List All</span>
                    </a>
                </p>

                @role(['EngineeringDept'])
                <p class="level-item">
                    <a href="/moms/form/">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>Add</span>
                    </a>
                </p>
                @endrole

            </div>

            <!-- Right side -->
            <div class="level-right">

                @role(['EngineeringDept'])

                @if ( in_array($status,['Frozen','Released']) )

                    @if ($is_latest)
                    <p class="level-item">
                        <a wire:click='reviseConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-version /></span>
                            <span>Revise</span>
                        </a>
                    </p>
                    @endif

                @else

                    <p class="level-item">
                        <a href='/moms/form/{{ $uid }}'>
                            <span class="icon"><x-carbon-edit /></span>
                        </a>
                    </p>

                    @role(['Approver'])
                    <p class="level-item">
                        <a wire:click='freezeConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-stamp /></span>
                        </a>
                    </p>

                    <p class="level-item">
                        <a wire:click='releaseConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-send /></span>
                        </a>
                    </p>
                    @endrole

                    <p class="level-item">
                        <a wire:click="triggerDelete('delete',{{ $uid }})">
                            <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                        </a>
                    </p>
                @endif
                @endrole

            </div>
        </nav>


        <div class="column">
            <div class="columns">

                <div class="column">
                    <figure class="image is-64x64">
                        {!! QrCode::size(64)->generate(url('/').'/moms/view/'.$uid) !!}
                    </figure>
                </div>

                <div class="column is-7">
                    <p class="title has-text-weight-light is-size-2">M{{$mom_no}} R{{$revision}}</p>
                    <p class="subtitle has-text-weight-light is-size-6">
                        {{ $subject }} -
                        [{{ $mom_start_date ? date('d M Y',strtotime($mom_start_date)) : ''}}  {{ $mom_end_date ? ' - '.date('d M Y',strtotime($mom_end_date)) : ''}}]
                    </p>


                    @if (count($all_revs) > 1)
                    <div class="tags has-addons">
                        @foreach ($all_revs as $key => $revId)
                            @if ($key != $revision)
                                <a href="/moms/view/{{$revId}}"
                                    class="tag {{ array_key_last($all_revs) == $key ? 'is-success':'' }} is-light mr-1">R{{$key}}</a>
                            @endif
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="column has-text-right is-4">
                    <span class="tag is-black">{{$meeting_types[$meeting_type]}}</span>
                    <span class="tag is-warning">{{$meeting_type}}</span>
                </div>

            </div>
        </div>


        <div class="column has-text-grey content">
            <strong>Tutanak / Minutes</strong>
            {!! $minutes !!}
        </div>

        <div class="column">
            <strong>Files(s)</strong>
            @livewire('file-list', [
                'canDelete' => false,
                'model' => 'MOM',
                'modelId' => $uid,
                'tag' => 'attachment',                          // Any tag other than model name
            ])
        </div>





        @if (strlen(trim($remarks)) > 0)
        <div class="column has-text-grey content">
            <strong>Remarks/Notes</strong>
            {!! $remarks !!}
        </div>
        @endif

        <div class="columns is-size-7 has-text-grey mt-6">

            <div class="column">
                <p>{{ $created_by }}</p>
                <p>{{ $created_at }}</p>
            </div>

            <div class="column has-text-centered">
                <p class="subtitle has-text-weight-light is-size-6">
                    <strong>Status</strong><br>
                    <span class="tag is-warning">{{$status}}</span>
                </p>
            </div>

            <div class="column has-text-right">
                <p>{{ $updated_by }}</p>
                <p>{{ $updated_at }}</p>
            </div>

        </div>

    </div>



</div>
