<div class="flex flex-col my-4">

    <h3 class="font-semibold text-gray-900 text-md mb-2">{{ $label }}</h3>

    <div class="flex flex-col md:flex-row gap-4">
        @foreach ($options as $value => $title)
            <div class="">
                <input type="radio" id="{{ $name . '_' . $value }}" name="{{ $name }}" value="{{ $value }}"
                    {{ $selected == $value ? 'checked' : '' }} class="form-check-input"
                    {{ $attributes->merge(['class' => 'form-check-input']) }}>
                <label for="{{ $name . '_' . $value }}" class="text-base ml-0.5">
                    {{ $title }}
                </label>
            </div>
        @endforeach
    </div>

    <div class="text-red-600 my-1 font-bold">
        @error('form.' . $name)
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
</div>
