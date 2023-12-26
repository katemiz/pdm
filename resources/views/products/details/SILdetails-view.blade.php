<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Detail Parts</h1>
    <h2 class="subtitle has-text-weight-light">Detail Part Properties</h2>
</header>

@if (session()->has('message'))
    <div class="notification">
        {{ session('message') }}
    </div>
@endif

<script>
    function showReleaseModal(id) {
        alert(id)
    }
</script>



<div class="card">

    <div class="card-content">

        <nav class="level mb-6">
            <!-- Left side -->

            <div class="level-left">
                    <a href="/parts/list" class="button is-outlined mr-2">
                        <span class="icon is-small"><x-carbon-show-data-cards /></span>
                        <span>List All</span>
                    </a>
                    <x-add-button />
            </div>

            <!-- Right side -->
            <div class="level-right">

                @role(['admin','EngineeringDept'])

                @if ($status == 'Frozen')

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
                        <a href='/details/form/{{ $uid }}'>
                            <span class="icon"><x-carbon-edit /></span>
                        </a>
                    </p>

                    <p class="level-item">
                        <a wire:click='freezeConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-stamp /></span>
                        </a>
                    </p>

                    <p class="level-item">
                        <a wire:click="deleteConfirm({{ $uid }})">
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
                        {!! QrCode::size(64)->generate(url('/').'/details/view/'.$uid) !!}
                    </figure>
                </div>

                <div class="column is-7">
                    <p class="title has-text-weight-light is-size-2">{{$part_number}}<span class="has-text-grey-lighter">-{{$version}}</span></p>
                    <p class="subtitle has-text-weight-light is-size-6">{{ $description }}</p>

                    {{-- @if (count($all_revs) > 1)
                    <div class="tags has-addons">
                        @foreach ($all_revs as $key => $revId)
                            @if ($key != $revision)
                                <a href="/documents/view/{{$revId}}"
                                    class="tag {{ array_key_last($all_revs) == $key ? 'is-success':'' }} is-light mr-1">R{{$key}}</a>
                            @endif
                        @endforeach
                    </div>
                    @endif --}}
                </div>

                <div class="column has-text-right is-4">

                    <table class="table is-fullwidth">
                        <tr>
                            <tr>
                                <th class="has-text-right">ECN</th>
                                <td class="has-text-right"><a class="tag is-link" href="/ecn/view/{{ $ecn_id }}">{{ $ecn_id }}</a></td>
                            </tr>
                        </tr>
                        <tr>
                            <th class="has-text-right">Part Unit</th>
                            <td class="has-text-right">{{ $unit }}</td>
                        </tr>
                        <tr>
                            <th class="has-text-right">Part Weight [kg]</th>
                            <td class="has-text-right">{{ $weight }}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>


        <div class="content">

            <div class="column">
                <label class="label">Material</label>
                {{ $material_definition }}
            </div>


            <div class="column content">
                <label class="label">General Part Notes</label>
                <ol>
                    @foreach ($notes as $note)
                    <li>{{ $note->text_tr }}</li>
                    @endforeach
                </ol>
            </div>


            <div class="column content">
                <label class="label">Special Part Notes</label>
                @foreach ($fnotes as $flag)
                <p>{{ $flag['no'] }} - {{ $flag['text_tr'] }}</p>
                @endforeach
            </div>


            <div class="columns">

                <div class="column">

                    {{-- ATTACHMENTS --}}
                    <div class="block">
                    <label class="label">CAD Files</label>
                    @livewire('file-list', [
                        'model' => 'Product',
                        'modelId' => $uid,
                        'showMime' => false,
                        'showSize' => false,
                        'tag' => 'CAD',                          // Any tag other than model name
                    ])
                    </div>

                </div>

                <div class="column">

                    <div class="block">
                        <label class="label">STEP/DXF Files</label>
                        @livewire('file-list', [
                            'model' => 'Product',
                            'modelId' => $uid,
                            'showMime' => false,
                            'showSize' => false,
                            'tag' => 'STEP',                          // Any tag other than model name
                        ])
                    </div>
                </div>

                <div class="column">
                    <div class="block">
                        <label class="label">Drawing and BOM</label>
                        @livewire('file-list', [
                            'model' => 'Product',
                            'modelId' => $uid,
                            'showMime' => false,
                            'showSize' => false,
                            'tag' => 'DWG-PDF',                          // Any tag other than model name
                        ])
                    </div>

                </div>

            </div>


            @if ($remarks)
            <div class="column">
                <label class="label">Remarks/Notes</label>
                <div class="notification">
                    {!! $remarks !!}
                </div>
            </div>
            @endif

        </div>


        <div class="columns is-size-7 has-text-grey mt-6">

            <div class="column">
                <p>{{ $created_by->email }}</p>
                <p>{{ $created_at }}</p>
            </div>

            <div class="column has-text-centered">
                <p class="subtitle has-text-weight-light is-size-6"><strong>Status</strong><br>{{$status}}</p>
            </div>

            <div class="column has-text-right">
                <p>{{ $updated_by->email }}</p>
                <p>{{ $updated_at }}</p>
            </div>

        </div>

    </div>

</div>
