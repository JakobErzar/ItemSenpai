@extends('app')
@section('title', 'Item Senpai')
@section('content')
    <h1>All Items!</h1>
    @foreach($items as $item)
        <h1>{{ $item->name }} - {{ $item->riot_id }}</h1><img src="{{ $item->icon }}">
        <h4>PlainText: {{ $item->plaintext }}</h4>
        <h4>Description: {{ $item->description }}</h4>
        <h4>Group: {{ $item->group }}</h4>
        <h4>Gold Base: {{ $item->gold_base }}, Gold Total {{ $item->gold_total }}</h4>
        
        
        @if (count($item->itemTags))
            <h2>Tags:</h2>
            <ul>
            @foreach ($item->itemTags as $tag)
                <li>{{ $tag->name }}</li><br>
            @endforeach
            </ul>
        @else
            <h2>No tags :(</h2>
        @endif
        
        @if (count($item->itemMaps))
            <h2>Maps:</h2>
            <ul>
            @foreach ($item->itemMaps as $map)
                <li>{{ $map->map_name }}</li><br>
            @endforeach
            </ul>
        @else
            <h2>No Maps :(</h2>
        @endif
        
        @if (count($item->itemFrom))
            <h2>From Items: (depth: {{ $item->depth }})</h2>
            @foreach ($item->itemFrom as $from)
                <img src="{{ $from->item->icon }}" style="margin:5px">
            @endforeach
        @else
            <h2>Nothing was used for this item :(</h2>
        @endif
        
        @if (count($item->ItemInto))
            <h2>To Items: (depth: {{ $item->depth }})</h2>
            @foreach ($item->ItemInto as $to)
                <img src="{{ $to->item->icon }}" style="margin:5px">
            @endforeach
        @else
            <h2>Nothing from this item :(</h2>
        @endif
        <hr>
    @endforeach
@stop