<div class="control">

    {{--
    @livewire('attach-component', [
        'model' => 'CR',                // ModelName
        'modelId' => $item->id,
        'isMultiple'=> false,           // can multiple files be selected
        'tag' => 'CR'                   // Any tag other than model name
    ])
    --}}

    <div class="content">

        <div class="columns">

            <div class="column is-narrow">
                <label class="file-label" id="fileLabelEl">
                    <input
                        class="file-input"
                        type="file"
                        wire:model="dosyalar"
                        id="fupload"
                        {{ $isMultiple ? 'multiple' : '' }} />
                    <span class="file-cta">
                        <span class="file-icon"><x-carbon-document-multiple-02 /></span>
                        <span class="file-label has-text-centered">{{ $isMultiple ? 'Add Files' : 'File' }}</span>
                    </span>
                </label>
            </div>

            <div class="column">

                @if (count($dosyalar) > 1 && $isMultiple)
                    <p class="notification is-size-7 has-text-gray p-1">
                    {{ count($dosyalar) }} files to be uploaded
                    </p>
                @endif

                @if (count($dosyalar) < 1 )
                    <p class="notification is-size-7 has-text-gray p-1">
                    {{ $isMultiple && count($dosyalar) < 1 ? 'No files to upload!' : 'No file to upload!' }}
                    </p>
                @endif

                <div id="files_div" class="py-0">

                    @if (count($dosyalar) > 0)
                        @foreach ($dosyalar as $dosya)

                        <div class="tags has-addons my-0">
                            <a wire:click="removeFile('{{$dosya->getClientOriginalName()}}')" class="tag is-danger is-light is-delete"></a>
                            <span class="tag is-black is-light">{{$dosya->getClientOriginalName()}}</span>
                        </div>

                        @endforeach
                    @endif
                </div>

            </div>

        </div>

        @error('dosyalar') <span class="error">{{ $message }}</span> @enderror

    </div>

</div>
