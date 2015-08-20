@extends('app')
@section('title', 'Item Senpai')
@section('content')
    <h1>All Champs!</h1>
    @foreach($champions as $champion)
        <h1>{{ $champion->name }}</h1><img src="{{ $champion->icon }}">
        <h4>{{ $champion->role1 }}</h4>
        <h4>{{ $champion->role2 }}</h4>
        <h2>Spells: </h2>
        @foreach ($champion->spells as $spell)
            <span>{{ $spell->name }}  </span><img src="{{$spell->icon}}" /><br>
        @endforeach
        <h2>Pics</h2>
        <img src="{{ $champion->splash }}"><br>
        <img src="{{ $champion->loading }}"><br><hr>
    @endforeach
@stop