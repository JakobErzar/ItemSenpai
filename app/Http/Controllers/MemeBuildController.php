<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\MemeBuild;
use App\Champion;

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
    
    public function make($id) {
        $build = MemeBuild::find($id);
        $build->load('itemset.itemset_blocks.items', 'itemset.champion');
        //return $build;
        $blocks = [];
        foreach($build->itemset[0]->itemset_blocks as $block) {
            $items = $block->items;
            $it = [];
            foreach($items as $item) {
                $it[] = [
                    'id' => $item->riot_id,
                    'count' => $item->pivot->count
                ];
            }
            
            
            $blocks[] = [
                "type" => $block->name,
                "recMath" => $block->recMath,
                "minSummonerLevel" => $block->minSummonerLevel,
                "maxSummonerLevel" => $block->maxSummonerLevel,
                "showIfSummonerSpell" => $block->showIfSummonerSpell,
                "hideIfSummonerSpell" => $block->hideIfSummonerSpell,
                'items' => $it
            ];
        }
        
        
        
        $res = [];
        
        $res[] = [
            "title" => $build->itemset[0]->name,
            "type" => $build->itemset[0]->type,
            "map" => $build->itemset[0]->map,
            "mode" => $build->itemset[0]->mode,
            "priority" => $build->itemset[0]->priority,
            "sortrank" => $build->itemset[0]->sortrank,
            "blocks" => $blocks
        ];
        return $res;
    }
    
    public function teach($id) {
        $build = MemeBuild::find($id);
        $build->load('itemset.itemset_blocks.items', 'itemset.champion');
        //return $build;
        $blocks = [];
        foreach($build->itemset[0]->itemset_blocks as $block) {
            $items = $block->items;
            $it = [];
            foreach($items as $item) {
                $it[] = [
                    'id' => $item->riot_id,
                    'count' => $item->pivot->count
                ];
            }
            
            
            $blocks[] = [
                "type" => $block->name,
                "recMath" => $block->recMath,
                "minSummonerLevel" => $block->minSummonerLevel,
                "maxSummonerLevel" => $block->maxSummonerLevel,
                "showIfSummonerSpell" => $block->showIfSummonerSpell,
                "hideIfSummonerSpell" => $block->hideIfSummonerSpell,
                'items' => $it
            ];
        }
        
        
        
        $res = [];
        
        $res[] = [
            "title" => $build->itemset[0]->name,
            "type" => $build->itemset[0]->type,
            "map" => $build->itemset[0]->map,
            "mode" => $build->itemset[0]->mode,
            "priority" => (boolean)$build->itemset[0]->priority,
            "sortrank" => $build->itemset[0]->sortrank == null ? 0 : $build->itemset[0]->sortrank,
            "blocks" => $blocks
        ];
        return View::make('memebuild.teach')->with(['Itemset' => json_encode($res), 'ChampionKey' => $build->itemset[0]->champion()->lists('key')]);
    }
}
