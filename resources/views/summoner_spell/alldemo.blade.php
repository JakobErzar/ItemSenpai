@extends('app')
@section('title', 'Item Senpai')
@section('content')
    <h1>All Summoner Spells!</h1>
    @foreach($summoners as $summoner)
        <h1>{{ $summoner->name }} - {{ $summoner->riot_id }}</h1><img src="{{ $summoner->icon }}">
        <h4>Description: {{ $summoner->description }}</h4>
        <h4>Required level: {{ $summoner->summoner_level }}</h4>
    @endforeach
@stop