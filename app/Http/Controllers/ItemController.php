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
         //$item = Item::where('riot_id', '=', $riotid)->with('ItemTags', 'ItemInto', 'ItemFrom')->get();
         $item = Item::where('riot_id', '=', $riotid)->with('ItemMaps')->get()->first();
         return $this->getItemStuff($item);
    }
    
    public function demo() {
         $items = Item::with('ItemMaps')->get();
         $new_items = array();
         foreach ($items as $item) {
             array_push($new_items, $this->getItemStuff($item));
         }
         return View::make('item.alldemo')->with('items', $new_items);
    }

    public function getItemStuff($item) {
         $tags = array();
         foreach ($item->ItemTags()->get() as $tag) {
             $newTag = $tag->name;
             array_push($tags, $newTag);
         }
         $item->ItemTags = $tags;
         
         $new_items = array();
         foreach ($item->ItemFrom()->get() as $tag) {
             $newItem = Item::where('riot_id', '=', $tag->other_item_id)->get()->first();
             array_push($new_items, $newItem);
         }
         $item->ItemFrom = $new_items;
         
         $new_items = array();
         foreach ($item->ItemInto()->get() as $tag) {
             $newItem = Item::where('riot_id', '=', $tag->other_item_id)->get()->first();
             array_push($new_items, $newItem);
         }
         
         $item->ItemInto = $new_items;
         return $item;
    }
}
