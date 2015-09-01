@extends('app')
@section('title', 'Item Senpai')
@section('content')
<h1>Download the itemset</h1>
<p>Contest rules state that you shouldn't need to download files. That's why at this moment, the only way for you to download the item set is to make the file by yourself and copy paste the content.</p>
<br><br>
<p>Open the following folder:<br><b>C:\Riot Games\League of Legends\Config\Champions\{{ $ChampionKey }}\Recommended\</b>
<textarea rows="20" cols="100">{{ $Itemset }}</textarea>
@stop