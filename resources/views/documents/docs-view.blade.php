
<div class="container mx-auto p-4">

    <livewire:header type="Page" title="Documents" subtitle="Document Details and Properties" />


    @if(session('msg'))
        <livewire:flash-message :msg="session('msg')">
    @endif










    <div class="flex flex-col  bg-gray-100 gap-4 p-4">

        <div class="flex flex-col md:flex-row ">

          <div class="w-3/4">
            <p class="text-6xl mb-2 font-light">{{ $document->docNo }}</p>
          </div>

          <div class="w-1/4 text-right">

            <button class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded inline-flex items-center">
                <x-carbon-pen class="w-4 h-4" />
              </button>

            <button class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded inline-flex items-center">
                <x-carbon-add-large class="w-4 h-4" />
              </button>

              <button class="bg-red-700 hover:bg-red-800 text-white p-2 rounded inline-flex items-center">
                <x-carbon-trash-can class="w-4 h-4" />
            </button>

            <livewire:dropdown :menu="[ ['title' =>'Title of Submenu','href'=> '/aa/b/'],['title' =>'Title of Submenu','href'=> '/aa/b/']]"/>

          </div>


        </div>

        <div>
          <p class="text-xl">{{ $document->title }}</p>
        </div>






        <livewire:rev-history :model="$document" redirect="/document/view/"/>


        @if ($document->remarks)
        <div class="text-xl font-bold">Remarks</div>

        <div class="text-base">{!! $document->remarks !!}</div>


            
        @endif


        <livewire:file-list :model="$document" collection="Doc" label="Files"/>



      </div>















    <livewire:info-box :model="$document" />


</div>



