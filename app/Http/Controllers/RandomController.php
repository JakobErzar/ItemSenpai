<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Item;
use App\Champion;

class RandomController extends Controller {

	public function getBuild() {
        $item_ids = Item::finalItem()->notGoodItemThingy()->lists('riot_id');
        $champion_ids = Champion::lists('riot_id');
        shuffle($champion_ids);
        shuffle($item_ids);
        $items = [];
        for ($i=0; $i < 6; $i++) { 
            $item = Item::where('riot_id', $item_ids[$i])->with('itemMaps')->first();
            array_push($items, $item);
        }
        return ['items' => $items, 'champion' => Champion::where('riot_id', $champion_ids[0])->first()];
    }

}
