<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\TeamComp;

class TeamCompsController extends Controller {

	public function random() {
        $builds = TeamComp::lists('id');
        shuffle($builds);
        $team = TeamComp::find($builds[0]);
        $team->load('itemsets.itemset_blocks.items', 'itemsets.champion');
        foreach($team->itemsets as $itemset) {
            $items = [];
            foreach($itemset->itemset_blocks as $block) {
                if ($block->type == 0) $itemset->items = $block->items;
            }
        }
        return $team;
    }

}
