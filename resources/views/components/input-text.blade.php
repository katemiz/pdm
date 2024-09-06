@props(['label'])
@props(['name'])

<div class="flex flex-col gap-x-6 my-4">

    <h3 class="mb-2 font-semibold text-md text-gray-900">{{ $label }}</h3>

    <input type="text" name="{{ $name }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg block w-full p-2.5"
        {{ $attributes }}>


    <div class="text-red-600 my-1 font-bold">
        @error('form.' . $name)
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
</div>
