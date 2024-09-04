<div class="flex flex-col gap-4 my-4">

  <h3 class="font-semibold text-gray-900 dark:text-white">{{ $label }}</h3>

  <div class="flex flex-col md:flex-row gap-4">
  @foreach ($options as $value => $title)
    <div class="">
        <input 
            type="radio" 
            id="{{ $name . '_' . $value }}" 
            name="{{ $name }}" 
            value="{{ $value }}" 
            {{ $selected == $value ? 'checked' : '' }} 
            class="form-check-input"
            {{ $attributes->merge(['class' => 'form-check-input']) }}
        >
        <label for="{{ $name . '_' . $value }}" class="pl-1">
            {{ $title }}
        </label>
    </div>
  @endforeach
  </div>
</div>