@extends('app')
@section('title', 'Item Senpai')
@section('content')
    <h1>All Meme Builds!</h1>
    @foreach($builds as $build)
        <h1>{{ $build->name }} ({{ $build->slug }})</h1>
        <h4>Description: {{ $build->description }}</h4>
        <iframe width="420" height="315" src="{{ $build->video }}" frameborder="0" allowfullscreen></iframe>        
        <br>
        @foreach ($build->itemset as $itemset)
            <img src="{{ $itemset->champion->icon }}" alt="">
            {{ $itemset->point1 }}{{ $itemset->point2 }}{{ $itemset->point3 }}, {{ $itemset->max1 }} > {{ $itemset->max2 }} > {{ $itemset->max3 }}
            @foreach($itemset->itemset_blocks as $block)
                <div>
                    {{ $block->name }}
                    @foreach($block->items as $item)
                        <img src="{{ $item->icon }}" alt=""> x {{ $item->pivot->count }}, 
                    @endforeach
                </div>
            @endforeach
        @endforeach
        
        
    @endforeach
@stop