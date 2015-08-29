<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Item;
use App\ItemTags;
use App\ItemFrom;
use App\ItemInto;
use App\ItemMaps;
use View;

class ItemController extends Controller {

	public function showByRiotId($riotid) {
         $item = Item::where('riot_id', '=', $riotid)->with('itemTags', 'itemInto.item', 'itemFrom.item', 'itemMaps')->get()->first();
         return $item;
    }
    
    public function demo() {
         $new_items = Item::with('itemTags', 'itemInto.item', 'itemFrom.item', 'itemMaps')->get();
         return View::make('item.alldemo')->with('items', $new_items);
    }
}
