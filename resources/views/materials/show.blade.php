<div class="container mx-auto p-4">

  <livewire:header type="Hero" title="{{ $conf['show']['title'] }}" subtitle="{{ $conf['show']['subtitle'] }}"/>

  @if(session('msg'))
      <livewire:flash-message :msg="session('msg')">
  @endif


  <div class="flex flex-col gap-4 p-4 bg-gray-100" >

      <div class="flex flex-col md:flex-row ">

        <div class="w-3/4">
            <p class="text-6xl mb-2 font-light">{{ $material->description }}</p>

            @if ($material->status != 'Active')
            <p class="text-base text-red-400">Do Not Use. Use Latest Revision</p>
            @endif
        </div>

        <div class="w-1/4 text-right">

          {{-- EDIT --}}
          @if ($permissions->edit)
            <span class='has-tooltip'>
              <x-tooltip>Edit Material</x-tooltip>

              <button wire:click="edit" class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded inline-flex items-center">
                <x-ikon name="Edit" />
              </button>
            </span>
          @endif

          {{-- ADD NEW --}}
          <span class='has-tooltip'>
            <x-tooltip>Add Material</x-tooltip>

            <button wire:click="add" class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded inline-flex items-center" >
                <x-ikon name="Add" />
            </button>
          </span>

          {{-- LIST ALL --}}
          <span class='has-tooltip'>
            <a href="/docs" class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded inline-flex items-center">
              <x-ikon name="List" />
            </a>

            <x-tooltip>List All Materials</x-tooltip>
          </span>

          {{-- MORE BUTTON --}}

          @if (count($moreMenu) > 0)
          <livewire:dropdown :menu="$moreMenu"/>
          @endif


        </div>

      </div>



      <div class="flex justify-between">
        <p class="text-xl">{{ $material->specification }}</p>
        <x-badge>{{ $conf['families'][$material->family] }}</x-badge>
      </div>




      @if ($material->remarks)
        <div class="text-xl font-bold">Remarks</div>
        <div class="text-base">{!! $material->remarks !!}</div>
      @endif

      <livewire:file-list :model="$material" collection="Material" label="Files"/>

  </div>

  <livewire:info-box :model="$material" />

</div>
