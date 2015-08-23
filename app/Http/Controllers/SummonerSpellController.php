<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use View;
use App\SummonerSpell;

class SummonerSpellController extends Controller {

	public function showByRiotId($riotid) {
         $summoner = SummonerSpell::where('riot_id', '=', $riotid)->get()->first();
         return ($summoner);
    }
    
    public function demo() {
         $summoners = SummonerSpell::all();
         return View::make('summoner_spell.alldemo')->with('summoners', $summoners);
    }

}
