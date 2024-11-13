<div class="container mx-auto p-4">

  <script src="{{ asset('/js/confirm_modal.js') }}"></script>

  <livewire:header type="Page" title="Documents" subtitle="Document Details and Properties" />

  @if(session('msg'))
      <livewire:flash-message :msg="session('msg')">
  @endif


  <div class="flex flex-col gap-4 p-4 bg-gray-100" >

      <div class="flex flex-col md:flex-row ">

        <div class="w-3/4">
            <p class="text-6xl mb-2 font-light">{{ $document->docNo }}</p>

            @if (!$document->is_latest)
            <p class="text-base text-red-400">Do Not Use. Use Latest Revision</p>
            @endif
        </div>

        <div class="w-1/4 text-right">

          <button wire:click="edit" class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded inline-flex items-center">
            <x-carbon-pen class="w-4 h-4" />
          </button>

          <button wire:click="add" class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded inline-flex items-center">
            <x-carbon-add-large class="w-4 h-4" />
          </button>

          <a href="/docs" class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded inline-flex items-center">
            <x-carbon-list class="w-4 h-4" />
          </a>

          <a href="javascript:confirmDelete()" class="bg-red-700 hover:bg-red-800 text-white p-2 rounded inline-flex items-center">
            <x-carbon-trash-can class="w-4 h-4" />
          </a>

          <livewire:dropdown :menu="$dd_menu"/>

        </div>

      </div>

      <div>
        <p class="text-xl">{{ $document->title }}</p>
      </div>


      <livewire:rev-history :model="$document" redirect="/document/view/" :rev="$document->revision"/>


      @if ($document->remarks)
        <div class="text-xl font-bold">Remarks</div>
        <div class="text-base">{!! $document->remarks !!}</div>
      @endif



      <livewire:file-list :model="$document" collection="Doc" label="Files"/>

  </div>

  <livewire:info-box :model="$document" />


  <script>

    function confirmDelete() {

      Swal.fire({
        title: 'Delete Document?',
        text: 'Once deleted, there is no reverting back!',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Ooops ...',

      }).then((result) => {
          if (result.isConfirmed) {
              Livewire.dispatch('onDeleteConfirmed')
          } else {
              return false
          }
      })
    }

  </script>

</div>
