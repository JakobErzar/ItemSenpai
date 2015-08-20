<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;

use Illuminate\Http\Request;

use App\Champion;

class ChampionController extends Controller {

	public function showById($id) {
         $champion = Champion::findOrFail($id)->with('spells')->get();
         return $champion;
    }
    
	public function showByName($name) {
         $champion = Champion::where('name', '=', $name)->with('spells')->get();
         return $champion;
    }
    
	public function showByRiotId($riotid) {
         $champion = Champion::where('riot_id', '=', $riotid)->with('spells')->get();
         return $champion;
    }

    public function nameDemo($name) {
         $champion = Champion::where('name', '=', $name)->with('spells')->first();
         return View::make('champion.demo')->with('champion', $champion);
    }
    public function demo() {
         $champions = Champion::with('spells')->get();
         return View::make('champion.alldemo')->with('champions', $champions);
    }
}
