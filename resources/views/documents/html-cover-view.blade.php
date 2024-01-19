@if (session()->has('message'))
<div class="notification is-info is-light mb-4">{{ session('message') }}</div>
@endif

<div class="column has-background-light">


    <div class="column">
        <p class="title has-text-weight-light is-size-3">{{$company->name}}</p>
        <p class="subtitle has-text-weight-light is-size-6">{{ $company->fullname }}</p>
    </div>


    <nav class="level my-6">
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">{{ $title }}</p>
            <p class="title">D{{$document_no}} R{{$revision}}</p>
          </div>
        </div>
    </nav>

    <div class="column has-text-centered">
    <figure class="image is-128x128 is-inline-block">
        <img src="{{ asset('images/doc_cover_icon.svg') }}">
    </figure>
    </div>

    <div class="column has-text-centered">

    <p class="tag is-black my-6">{{$doc_types[$doc_type]}}</p>
    </div>

    <div class="column has-text-centered">
        <p class="my-3">{{ $created_by }}<br>{{ $created_at }}</p>
        <p class="my-3">{{ $updated_by }}<br>{{ $updated_at }}</p>
    </div>

    @if (strlen(trim($remarks)) > 0)
    <div class="column has-text-grey has-text-centered is-size-6">
        {!! $remarks !!}
    </div>
    @endif

    <div class="column has-text-centered">
        <figure class="image is-64x64  is-inline-block">
            {!! QrCode::size(64)->generate(url('/').'/documents/view/'.$uid) !!}
        </figure>
    </div>

    <div class="column has-text-centered">
        <p class="subtitle has-text-weight-light is-size-6"><strong>Status</strong><br>{{$status}}</p>
    </div>

</div>
