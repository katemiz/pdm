<div class="container mx-auto p-4">

  <livewire:header type="Hero" title="{{ config('conf_users.show.title') }}" subtitle="{{ config('conf_users.show.subtitle') }}"/>

  @if(session('msg'))
      <livewire:flash-message :msg="session('msg')">
  @endif


  <div class="flex flex-col gap-4 p-4 bg-gray-100" >

      <div class="flex flex-col md:flex-row ">

        <div class="w-3/4">
            <p class="text-6xl mb-2 font-light">{{ $user->email }}</p>
        </div>

        <div class="w-1/4 text-right">

          {{-- EDIT --}}
          @if ($permissions->edit)
            <span class='has-tooltip'>
              <x-tooltip>Edit User</x-tooltip>

              <button wire:click="edit" class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded inline-flex items-center">
                <x-ikon name="Edit" />
              </button>
            </span>
          @endif

          {{-- ADD NEW --}}
          <span class='has-tooltip'>
            <x-tooltip>Add New User</x-tooltip>

            <button wire:click="add" class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded inline-flex items-center" >
                <x-ikon name="Add" />
            </button>
          </span>

          {{-- LIST ALL --}}
          <span class='has-tooltip'>
            <a href="/usrs" class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded inline-flex items-center">
              <x-ikon name="List" />
            </a>

            <x-tooltip>List All Users</x-tooltip>
          </span>

          {{-- MORE BUTTON --}}

          @if (count($moreMenu) > 0)
          <livewire:dropdown :menu="$moreMenu"/>
          @endif


        </div>

      </div>



      <div class="flex justify-between">
        <p class="text-xl">{{ $user->name }} {{ $user->lastname }}</p>
        <x-badge>{{ $user->email }} / {{ $this->company }}</x-badge>
      </div>




      @if ($user->notes)
        <div class="text-xl font-bold">Notes</div>
        <div class="text-base">{!! $user->notes !!}</div>
      @endif

      <livewire:file-list :model="$user" collection="User" label="Files"/>

  </div>

  <livewire:info-box :model="$user" :viewBtn="config('conf_users.viewBtn')"/>

</div>
