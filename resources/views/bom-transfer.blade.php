@foreach ($olanlar as $result)
    <p>{{ $result }}</p>
@endforeach


<h1>All items: {{ count(value: $all_items) }}</h1>

<h1>Count Results: {{ count(value: $results) }}</h1>
<h1>Olanlar: {{ count(value: $olanlar) }}</h1>


@foreach ($results as $k => $result)
    <h1>{{ $k }}</h1>
    <p>{{ print_r($result) }}</p>

@endforeach