{{-- <div class="flex flex-col my-4">

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
</div> --}}





<div class="flex flex-col my-4">

    <h3 class="font-semibold text-gray-900 text-md mb-2">{{ $label }}</h3>

    <div class="flex flex-col md:flex-row gap-4">
        <select wire:model='family' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option>Select Family</option>

            @foreach ($options as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
    </div>

    <div class="text-red-600 my-1 font-bold">
        @error('form.' . $name)
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

</div>




{{-- 
<form class="max-w-sm mx-auto">
  <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
  <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    <option selected>Choose a country</option>
    <option value="US">United States</option>
    <option value="CA">Canada</option>
    <option value="FR">France</option>
    <option value="DE">Germany</option>
  </select>
</form> --}}

