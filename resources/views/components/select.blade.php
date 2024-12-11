<div class="flex flex-col my-4">

    <h3 class="font-semibold text-gray-900 text-md mb-2">{{ $label }}</h3>

    <div class="flex flex-col md:flex-row gap-4">
        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option>{{ $label }}</option>

            @foreach ($options as $key => $value)
                <option value="{{$key}}" {{ $selected == $key ? 'selected' : '' }}>{{$value}}</option>
            @endforeach
        </select>
    </div>

    <div class="text-red-600 my-1 font-bold">
        @error('form.' . $name)
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

</div>
