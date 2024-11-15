{{-- 
@props(['id' => false])

<div
    id="{{$id}}" 
    
    class="hidden absolute z-50 whitespace-normal break-words rounded-lg bg-gray-600 py-1.5 px-3 font-sans text-sm font-normal text-white focus:outline-none">
    {{ $slot }}
</div> --}}


<span class='tooltip rounded shadow-lg p-1 bg-gray-100 text-gray-500 -mt-12 p-2'>{{ $slot }}</span>
