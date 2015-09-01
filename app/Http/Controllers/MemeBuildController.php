<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\MemeBuild;

use View;

class MemeBuildController extends Controller {

    public function demo() {
         $builds = MemeBuild::with('itemset.itemset_blocks.items', 'itemset.champion', 'itemset.summoner1', 'itemset.summoner2')->get();
         //return $builds;
         return View::make('memebuild.alldemo')->with('builds', $builds);
    }
    public function random() {
        $builds = MemeBuild::lists('id');
        shuffle($builds);
        $build = MemeBuild::find($builds[0]);
        $build->load('itemset.itemset_blocks.items', 'itemset.champion');
        $items = [];
        foreach($build->itemset[0]->itemset_blocks as $block) {
            if ($block->type == 0) $build->itemset[0]->items = $block->items;
        }
        return $build;
    }
}
