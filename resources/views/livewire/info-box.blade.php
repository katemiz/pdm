<?php

use function Livewire\Volt\{computed, state};
use App\Models\User;

state('createdBy');
state('created_at');
state('status');



$author = computed(function () {
    return User::find($this->createdBy)->get();
});



$modifier = computed(function () {
    return User::find($this->createdBy)->get();
});

 

 

 
?>





?>
<div class="columns is-size-7 has-text-grey">

    <div class="column has-background-white-ter	">
        {{-- <label class="label">Created By</label> --}}
        <p class="is-size-7 has-text-grey">{{ $this->author->name }} {{ $this->author->lastname }}</p>
        <p>{{ $created_at }}</p>
    </div>


    <div class="column has-background-white-ter	has-text-right">
        {{-- <label class="label">Status</label> --}}

        @switch($status)
        @case('wip')
            <p>Work In Progress</p>
            @break
        @case('accepted')
            <p class="has-text-info">Kabul Edildi - Accepted</span>
            @break
        @case('rejected')
            <a onclick="showModal('m10')">Red Edildi - Rejected</a>
            <p>{{ $engBy->name }} {{ $engBy->lastname }}</p>
            <p>{{ $created_at }}</p>
            @break
        @endswitch

    </div>


</div>
