<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">{{ $constants['read']['title'] }}</h1>

    @if ( $constants['read']['subtitle'] )
        <h2 class="subtitle has-text-weight-light">{{ $constants['read']['subtitle'] }}</h2>
    @endif
</header>

@if (session()->has('message'))
    <div class="notification">
        {{ session('message') }}
    </div>
@endif



<div class="card">

    <div class="card-content">

        <div class="content">
            <div class="columns">

                <div class="column is-half">
                    <div class="field has-addons">

                        <p class="control">
                            <a href="/ecn/list" class="button is-info is-light is-small">
                            <span class="icon is-small"><x-carbon-list /></span>
                            </a>
                        </p>

                        @role(['EngineeringDept'])
                        @if ($status == 'wip' )
                            <p class="control ml-1">
                                <a class="button is-link is-light is-small" href='/ecn/form/{{ $item->id }}'>
                                    <span class="icon is-small"><x-carbon-edit /></span>
                                    <span>Edit</span>
                                </a>
                            </p>

                            <p class="control ml-1">
                                <button class="button is-danger is-light is-small" wire:click.prevent="startCRDelete({{$item->id}})">
                                    <span class="icon is-small"><x-carbon-trash-can /></span>
                                </button>
                            </p>
                        @endif
                        @endrole

                    </div>
                </div>

                @if (in_array($status,['wip']))
                <div class="column">
                    <div class="field has-addons is-pulled-right">

                        <p class="control">
                            <a wire:click="closeECN({{ $item->id }})" class="button is-success is-light is-small">
                                <span class="icon is-small"><x-carbon-task-complete /></span>
                                <span>Finalize / Tamamla</span>
                            </a>
                        </p>

                    </div>
                </div>
                @endif

            </div>
        </div>

        <div class="media">
            <div class="media-left">
                <figure class="image is-48x48">
                    <x-carbon-message-queue />
                </figure>
            </div>
            <div class="media-content">
                <p class="title is-4"> ECN-{{ $item->id }}</p>
                <p class="subtitle is-6">CR-{{ $item->c_notice_id}}</p>
            </div>
        </div>


        <label class="label">Yapılacakların Tanımı - Actions List</label>

        <div class="notification content">
            {!! $item->pre_description !!}
        </div>

        <label class="label">Dosyalar</label>

        @livewire('file-list', [
            'model' => 'ECN',
            'modelId' => $item->id,
            'tag' => 'ECN',                          // Any tag other than model name
        ], 'ECN')


        {{-- @livewire('file-upload', [
            'hasForm' => false,                      // true when possible to add/remove file otherwise false
            'model' => 'CR',
            'modelId' => $item->id,
            'isMultiple'=> false,                   // can multiple files be selected
            'tag' => 'CR',                          // Any tag other than model name
            'canEdit' => $canEdit], 'CR')

        <hr> --}}

        <table class="table is-fullwidth">
            <tr>
                <td class="is-half">
                    <label class="label">Başlatan / Created By</label>
                    <p>{{ $createdBy->name }} {{ $createdBy->lastname }}</p>
                    <p>{{ $created_at }}</p>
                </td>
                <td class="has-text-right">
                    <label class="label">Durum / Status</label>

                    @switch($status)
                    @case('wip')
                        <p class="has-text-info">Çalışılıyor - Work In Progress</p>
                        @break
                    @case('accepted')
                        <p class="has-text-info">Kabul Edildi - Accepted</span>
                        @break
                    @case('rejected')
                        <a onclick="showModal('m10')">Red Edildi - Rejected</a>
                        <p>{{ $engBy->name }} {{ $engBy->lastname }}</p>
                        <p>{{ $created_at }}</p>
                        @break

                    @case('complete')
                        <a onclick="showModal('m10')">Tamamlandı - Completed</a>
                        {{-- <p>{{ $engBy->name }} {{ $engBy->lastname }}</p> --}}
                        <p>{{ $updated_at }}</p>
                        @break
                    @endswitch

                </td>
            </tr>
        </table>

    </div>


    <div class="modal" id="m10">
        <div class="modal-background" onclick="hideModal('m10')"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Red Nedeni / Rejection Reason</p>
            <a class="delete" aria-label="close" onclick="hideModal('m10')"></a>
        </header>
        <section class="modal-card-body">
            <p>rejectReason </p>
        </section>
        </div>
    </div>



    <div class="modal" id="m20">
        <div class="modal-background" onclick="hideModal('m20')"></div>
        <div class="modal-card">
            <form wire:submit="rejectCR">
                <header class="modal-card-head">
                    <p class="modal-card-title">Red Nedeni / Rejection Reason</p>
                    <a class="delete" aria-label="close" onclick="hideModal('m20')"></a>
                </header>
                <section class="modal-card-body">
                    <textarea type="text" wire:model='rejectReason' class="textarea" placeholder="Reddetme nedenini yazınız." rows="5"></textarea>
                </section>
                <footer class="modal-card-foot">
                    <a onclick="hideModal('m20')" class="button">İptal / Cancel</a>
                    <button class="button is-light is-danger">Red / Reject</button>
                </footer>
            </form>
        </div>
    </div>

</div>
