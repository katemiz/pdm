<div class="flex bg-white p-3">


    <div class="flex w-1/2 bg-teal-100">

        {{-- <label class="file-label" id="fileLabelEl"> --}}

            {{-- <input
                class="file-input"
                type="file"
                wire:model="dosyalar"
                id="fupload"
                {{ $this->is_multiple ? 'multiple' : '' }} /> --}}

            <input 
                wire:model="dosyalar"
                id="fupload"
                type="file"
                class="w-full text-gray-500 font-medium text-sm bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded" 
                {{ $isMultiple ? 'multiple' : '' }}
            />
            
            
            {{-- <span class="file-cta">
                <span class="file-icon"><x-carbon-document-multiple-02 /></span>
                <span class="file-label has-text-centered">{{ $this->is_multiple ? 'Add Files' : 'File' }}</span>
            </span> --}}

        {{-- </label> --}}
    </div>

    
    <div class="flex flex-col flex-grow w-1/2 pl-6" id="files_div">

        {{-- @if (count($dosyalar) > 1 && $isMultiple)
            <p class="notification is-size-7 has-text-gray p-1">
            {{ count($dosyalar) }} files to be uploaded
            </p>
        @endif --}}

        {{-- @if (count($dosyalar) < 1 )
            <p class="notification is-size-7 has-text-gray p-1">
            {{ $isMultiple && count($dosyalar) < 1 ? 'No files to upload!' : 'No file to upload!' }}
            </p>
        @endif --}}


        {{-- <div id="files_div" class="py-0"> --}}

            @if (count($dosyalar) > 0)

                @foreach ($dosyalar as $dosya)

                    <div class="flex m-1">

                        <div class="flex bg-red-400 px-1 py-1 items-center">
                            <a wire:click="removeFile('{{$dosya->getClientOriginalName()}}')">
                                <x-carbon-close class="w-6 h-6 text-white" />
                            </a>
                        </div>

                        <div class="w-full  px-2 py-1">{{$dosya->getClientOriginalName()}}</div>
                    </div>

                @endforeach

            @endif
        {{-- </div> --}}

    </div>


    @error('dosyalar') <span class="error">{{ $message }}</span> @enderror

</div>


<script>

    document.getElementById("fupload").onchange = ()=>{
        let files = document.getElementById("fupload").files;
        console.log(files)
    }
    
</script>

