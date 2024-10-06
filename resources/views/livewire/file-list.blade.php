<div class="flex items-center justify-center py-4 my-4">

    <div class="overflow-x-auto w-full">


        <div class="text-xl font-bold">{{ $label }}</div>

        @if ( $media->count() > 0 )


            <table class="min-w-full bg-gray-100 shadow-md ">

                @if ($show_header)

                    <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-3 px-4 text-left">Filename</th>
                        <th class="py-3 px-4 text-left">MIME Type</th>
                        <th class="py-3 px-4 text-left">Size</th>

                        @if ($is_editable)
                        <th class="py-3 px-4 text-left">Actions</th>
                        @endif
                    </tr>
                    </thead>

                @endif



                <tbody class="text-blue-gray-900">

                    @foreach ($this->media as $m)

                        <tr class="border-b border-blue-gray-200">

                            <td class="py-1 px-4">
                                <a wire:click="downloadMedia({{$m->id}})" class="text-blue-800 font-bold py-2 rounded inline-flex items-center">
                                    <x-carbon-document class="w-5 h-5 me-2" />
                                    <span>{{ $m->file_name }}</span>
                                </a>
                            </td>

                            <td class="py-1 px-4">{{ $m->mime_type }}</td>
                            <td class="py-1 px-4">{{ $m->size }}</td>



                            @if ($is_editable)
                            <td class="py-1 px-4">
                                <a wire:click="triggerMediaDelete({{$m->id}})" class="font-medium text-blue-600 hover:text-blue-800">
                                    <x-carbon-trash-can class="w-5 h-5 me-2 text-red-500" />
                                </a>
                            </td>
                            @endif
                        </tr>

                    @endforeach

                </tbody>
            </table>

        @else


            <div class="p-4 mt-4 text-sm text-amber-800 rounded-lg bg-amber-100" role="alert">
                No files found.
            </div>

        @endif

    </div>

</div>

<script >

    window.addEventListener('deleteConfirm',function(e) {

        Swal.fire({
            title: 'Delete attached file?',
            text: 'Once deleted, there is no reverting back!',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sure, Delete File',
            cancelButtonText: 'No, Ooops ...',

        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("deleteConfirmed", {id:e.detail.type})
            } else {
                return false
            }
        })

    })



    window.addEventListener('mediaDeleted',function(e) {

        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'File has been deleted',
            showConfirmButton: false,
            timer: 1500
        })

    })

</script>


