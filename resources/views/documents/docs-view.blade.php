
<div class="container mx-auto p-4">

    <livewire:header type="Page" title="Documents" subtitle="Document Details and Properties" />


    @if(session('msg'))
        <livewire:flash-message :msg="session('msg')">
    @endif



    <div class="flex flex-col md:flex-row justify-between items-center">

        <div class="w-full md:w-1/4">aaa</div>
        <div class="w-full md:w-3/2">aaaa</div>
    </div>


    <livewire:file-list :id="$id" modelname="Document" collection="Doc" label="Customer Drawings"/>



    <livewire:info-box :model="$document" />


</div>



