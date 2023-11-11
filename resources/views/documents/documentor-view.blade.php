


<div class="columns is-gapless">

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>


    <div class="column is-narrow has-background-grey-lighter">
        @livewire('lw-toc', [
            ])
    </div>

    <div class="column m-4">

        <header class="mb-6">
            <h1 class="title has-text-weight-light is-size-1 mt-6">HTML Document</h1>
            <h2 class="subtitle has-text-weight-light">View HTML Document Attributes</h2>
        </header>

        @if (session()->has('message'))
            <div class="notification">
                {{ session('message') }}
            </div>
        @endif


        @if ($paction === 'COVER')

            <div class="card">

                <div class="card-content">
            
                    <nav class="level mb-6">
                        <!-- Left side -->
                        <div class="level-left">
            
                            <p class="level-item">
                                <a href="/documents/file/list">
                                    <span class="icon is-small"><x-carbon-table /></span>
                                    <span>List All</span>
                                </a>
                            </p>
            
                            <p class="level-item">
                                <a href="/documents/file/form/">
                                    <span class="icon is-small"><x-carbon-add /></span>
                                    <span>Add</span>
                                </a>
                            </p>
            
                        </div>
            
                        <!-- Right side -->
                        <div class="level-right">
            
                            @role(['admin','company_admin','engineer'])
            
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
                                    <a href='/documents/form/{{ $uid }}'>
                                        <span class="icon"><x-carbon-edit /></span>
                                    </a>
                                </p>
            
                                <p class="level-item">
                                    <a wire:click='freezeConfirm({{ $uid }})'>
                                        <span class="icon"><x-carbon-stamp /></span>
                                    </a>
                                </p>
            
                                <p class="level-item">
                                    <a wire:click="triggerDelete('document',{{ $uid }})">
                                        <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                                    </a>
                                </p>
                            @endif
            
            
                            @endrole
            
                        </div>
                    </nav>
            
                    <div class="column">
                        <div class="columns">
            
                            <div class="column is-8">
                                <p class="title has-text-weight-light is-size-2">D{{$document_no}} R{{$revision}}</p>
                                <p class="subtitle has-text-weight-light is-size-6">{{ $title }}</p>
            
                                @if (count($all_revs) > 1)
                                <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
                                    <ul>
                                    @foreach ($all_revs as $key => $revId)
                                        @if ($key != $revision)
                                        <li><a href="/documents/view/{{$revId}}">R{{$key}}</a></li>
                                        @endif
                                    @endforeach
                                    </ul>
                                </nav>
                                @endif
                            </div>
            
                            <div class="column has-text-right is-4">
                                <span class="tag is-black">{{$doc_types[$doc_type]}}</span>
                            </div>
            
                        </div>
                    </div>
            
            
            
                    @if (strlen(trim($remarks)) > 0)
                    <div class="column has-text-grey">
                        <strong>Remarks/Notes</strong>
                        {!! $remarks !!}
                    </div>
                    @endif
            
            
                    <div class="column">
                        <strong>Original Files(s)</strong>
                        @livewire('file-list', [
                            'canDelete' => false,
                            'model' => 'Document',
                            'modelId' => $uid,
                            'tag' => 'document',                          // Any tag other than model name
                        ])
                    </div>
            
                    <div class="columns is-size-7 has-text-grey mt-6">
            
                        <div class="column">
                            <p>{{ $created_by }}</p>
                            <p>{{ $created_at }}</p>
                        </div>
            
                        <div class="column has-text-centered">
                            <p class="subtitle has-text-weight-light is-size-6"><strong>Status</strong><br>{{$status}}</p>
                        </div>
            
                        <div class="column has-text-right">
                            <p>{{ $updated_by }}</p>
                            <p>{{ $updated_at }}</p>
                        </div>
            
                    </div>
            
                </div>
            
            </div>

            
        @endif


        @if ($paction === 'FORM')

        @livewire('lw-page', [
            'pid' => $pid
        ])

        
        @endif






    </div>
</div>