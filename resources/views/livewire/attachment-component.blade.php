<div class="control">

    <script>
        window.addEventListener('runConfirmDialog',function(e) {

            Swal.fire({
                title: e.detail.title,
                text: e.detail.text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Ooops ...',

            }).then((result) => {
                if (result.isConfirmed) {
                    this.Livewire.dispatch('runDelete')
                } else {
                    return false
                }
            })
        });

        window.addEventListener('infoDeleted',function(e) {

            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'File has been deleted',
                showConfirmButton: false,
                timer: 1500
            })
        })
    </script>




    @if ($attachments->count() > 0)
        <div class="column">

        {{-- <p class="subtitle">Attachments</p> --}}

        <table class="table is-fullwidth is-size-7">

            @foreach ($attachments as $key => $attachment)
            <tr class="my-0">
                <td class="is-narrow">
                    @if ($isMultiple)
                        {{ ++$key }}
                    @else
                        <span class="icon"><x-carbon-attachment /></span>
                    @endif
                </td>
                <td>
                    <a wire:click="downloadFile('{{ $attachment->id }}')">{{ $attachment->original_file_name }}</a>
                </td>
                <td class="is-narrow">{{ $attachment->mime_type }}</td>
                <td class="is-narrow">{{ $attachment->file_size }}</td>

                @if ($canEdit)
                <td class="is-narrow has-text-right">
                    <a wire:click="deleteAttachConfirm('{{$attachment->id}}')">
                        <span class="icon is-small has-text-danger"><x-carbon-trash-can /></span>
                    </a>
                </td>
                @endif

            </tr>
            @endforeach

        </table>
        </div>
    @else
    <p>{{ $isMultiple ? 'No files' : 'No file' }}</p>
    @endif


    @if ($canEdit)
    <div class="content">

        {{-- @role(config('requirements.roles.w')) --}}

        <form wire:submit="uploadAttach" >

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

                <div class="column is-narrow">
                    <button class="button is-link {{ count($dosyalar) < 1 ? 'is-hidden': ''}}" id="uploadButton">
                        <span class="icon"><x-carbon-upload /></span>
                        <span>Upload</span>
                    </button>
                </div>

            </div>

            @error('dosyalar') <span class="error">{{ $message }}</span> @enderror

        </form>

        {{-- @endrole --}}

    </div>
    @endif

</div>