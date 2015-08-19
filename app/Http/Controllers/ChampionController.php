<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Champion;

class ChampionController extends Controller {

	public function showById($id) {
         $champion = Champion::findOrFail(1)->with('spells')->get();
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

}
