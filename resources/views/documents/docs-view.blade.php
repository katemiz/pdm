
<div class="container mx-auto p-4">

    <livewire:header type="Page" title="Documents" subtitle="Document Details and Properties" />


    @if(session('msg'))
        <livewire:flash-message :msg="session('msg')">
    @endif










    <div class="flex flex-col  bg-gray-100 gap-4 p-4">





        <div class="flex flex-col md:flex-row ">


          <div class="w-3/4">

            <p class="text-5xl mb-2">{{ $document->docNo }}</p>

          </div>


          <div class="w-1/4 text-right">

            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              <x-carbon-pen class="w-4 h-4" />
            </button>

            <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              <x-carbon-trash-can class="w-4 h-4" />
            </button>

          </div>


        </div>

        <div>
          <p>{{ $document->title }}</p>

        </div>






          <livewire:rev-history :model="$document" redirect="/document/view/"/>





      </div>













    <livewire:file-list :model="$document" collection="Doc" label="Files"/>


    <livewire:info-box :model="$document" />


</div>



