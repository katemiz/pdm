
<div class="container mx-auto p-4">



    <livewire:header type="Page" title="Documents" subtitle="Document Details and Properties" />




    @if(session('msg'))
        <livewire:flash-message :msg="session('msg')">
    @endif


    <livewire:info-box modelname="Document" :id="$id" />




</div>



