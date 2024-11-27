@props(['is_multiple'])
@props(['name'])
@props(['files'])


<div class="flex bg-white py-3">

    <div class="flex w-1/3 bg-teal-100">
        <input
            wire:model="files"
            name="{{$name}}"
            id="uploadInput"
            type="file"
            class="w-full text-gray-500 font-medium text-sm bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded"
            {{ $is_multiple ? 'multiple' : '' }}
        />
    </div>

    <div class="flex flex-col flex-grow w-2/3 pl-6" id="files_div">

       @if (count($files) > 0)

           @foreach ($files as $file)

               <div class="flex m-1">

                   <div class="flex bg-red-400 px-1 py-1 items-center">
                       <a wire:click="removeFile('{{$file->getClientOriginalName()}}')">
                           <x-carbon-close class="w-6 h-6 text-white" />
                       </a>
                   </div>

                   <div class="w-full  px-2 py-1">{{$file->getClientOriginalName()}}</div>
               </div>

           @endforeach

       @endif

    </div>


    @error('files') <span class="error">{{ $message }}</span> @enderror

</div>


<script>

    document.getElementById("uploadInput").onchange = ()=>{
        let files = document.getElementById("uploadInput").files;
    }

</script>

