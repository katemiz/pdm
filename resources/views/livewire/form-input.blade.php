<div class="form-group my-32">

    <label for="{{ $name }}" class="block font-medium text-gray-700">
        {{ $label }}
    </label>

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        {{-- wire:model.lazy="{{ $name }}"  --}}
        wire:model="girdi"
        placeholder="{{ $placeholder }}"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
    >

</div>