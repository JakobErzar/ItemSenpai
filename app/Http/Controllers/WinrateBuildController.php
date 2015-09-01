<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\WinrateBuild;

class WinrateBuildController extends Controller {

	public function random() {
        $builds = WinrateBuild::lists('id');
        shuffle($builds);
        $build = WinrateBuild::find($builds[0]);
        $build->load('itemsets.itemset_blocks.items', 'itemsets.champion');
        $items = [];
        foreach($build->itemsets[0]->itemset_blocks as $block) {
            if ($block->type == 0) $build->itemsets[0]->items = $block->items;
        }
        return $build;
    }

}
