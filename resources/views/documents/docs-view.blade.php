
<div class="container mx-auto p-4">



    <livewire:header type="Page" title="Documents" subtitle="Document Details and Properties" />




    @if(session('msg'))
        <livewire:flash-message :msg="session('msg')">
    @endif







    {{ print_r($document->status)}}



    <livewire:info-box :created_by="$document->user_id" :created_at="$document->created_at" :status="$document->status" />




</div>



