<div wire:init="getClients">
    @if($is_loading_client)
        <h1>Loading ...</h1>
    @else
        <ul>
            @foreach ($clients as $client)
                <li>{{ $client->first_name }}</li>
            @endforeach
        </ul>
    @endif

    @if($is_loading_school)
        <h1>Loading ...</h1>
    @else
        <ul>
            @foreach ($schools as $school)
                <li>{{ $school->sch_name }}</li>
            @endforeach
        </ul>
    @endif
</div>