@props(['label'])
@props(['name'])

 






<div class="flex flex-col gap-x-6 my-4">


    <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">{{ $label }}</h3>
  
  
    <input
        type="text"
        name="{{ $name }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        {{ $attributes }}>



    

    <div>
        @error($name) <span class="error">{{ $message }}</span> @enderror
    </div>
  
  
  </div>
  