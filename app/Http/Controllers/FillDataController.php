<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Champion;
use App\Spell;
use App\Item;
use App\ItemTags;
use App\ItemFrom;
use App\ItemInto;
use App\ItemMaps;
use App\SummonerSpell;

use App\MemeBuild;
use App\WinrateBuild;
use App\TeamComp;
use App\RoleBuild;
use App\Itemset;
use App\ItemsetBlock;

use File;

require('simple_html_dom.php');

class FillDataController extends Controller {
    public function getIndex() {
        echo '<h2>Yay! You are in for some sweet clicking and waiting!</h2>';
        echo '<h4>Champions: </h4><a href="' .url().'/api/filldata/champions" target="_blank">link</a>';
        echo '<h4>Items: </h4><a href="' .url().'/api/filldata/items" target="_blank">link</a>';
        echo '<h4>Item maps: </h4><a href="' .url().'/api/filldata/items-maps" target="_blank">link</a>';
        echo '<h4>Summoner spells: </h4><a href="' .url().'/api/filldata/summoner-spells" target="_blank">link</a>';
        echo '<h4>Meme builds: </h4><a href="' .url().'/api/filldata/meme-builds" target="_blank">link</a>';
        echo '<h4>Champion gg: </h4><a href="' .url().'/api/filldata/winrate-builds/0/5" target="_blank">link</a>';
        echo '<h4>Team comps: </h4><a href="' .url().'/api/filldata/team-comps" target="_blank">link</a>';
        echo '<h4>Role builds: </h4><a href="' .url().'/api/filldata/role-builds" target="_blank">link</a>';
    }
    
    
    
	public function champions() {
        $cdn_ver = '5.16.1';
        
        $json = file_get_contents('https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion?champData=all&api_key=2767f871-228a-412a-9063-d754163404f4');
        $obj = json_decode($json);
        
        $champs = array();
        foreach($obj->data as $champ){
         
            $champion = Champion::firstOrNew(['riot_id' => $champ->id, 'key' => $champ->key, 'name' => $champ->name]);
            $champion->icon = 'http://ddragon.leagueoflegends.com/cdn/'.$cdn_ver.'/img/champion/'.$champ->image->full;
            $champion->splash = 'http://ddragon.leagueoflegends.com/cdn/img/champion/splash/'.$champ->key.'_0.jpg';
            $champion->loading = 'http://ddragon.leagueoflegends.com/cdn/img/champion/loading/'.$champ->key.'_0.jpg';
            if(count($champ->tags) > 0) $champion->role1 = $champ->tags[0];
            if(count($champ->tags) > 1) $champion->role2 = $champ->tags[1];
            
            $spells = array();
            $symbols = array('Q', 'W', 'E', 'R');
            $champion->save();
            for ($i=0; $i < 4; $i++) { 
                $spell = $champ->spells[$i];
                $new_spell = Spell::firstOrNew(['name' => $spell->name, 'key' => $spell->key, 'champion_id' => $champ->id]);
                $new_spell->max_rank = $spell->maxrank;
                $new_spell->symbol = $symbols[$i];
                $new_spell->icon = 'http://ddragon.leagueoflegends.com/cdn/'.$cdn_ver.'/img/spell/'.$spell->image->full;
                $new_spell->save();
                array_push($spells, $new_spell);
            }
            $champion->spells = $spells;
                   
            array_push($champs, $champion);
        }
        return $champs;
    }

    public function items() {
        $cdn_ver = '5.16.1';
        
        $json = file_get_contents('https://global.api.pvp.net/api/lol/static-data/euw/v1.2/item?itemListData=all&api_key=2767f871-228a-412a-9063-d754163404f4');
        $obj = json_decode($json);
        
        $items = array();
        foreach($obj->data as $item){
            $it = Item::firstOrNew(['riot_id' => $item->id, 'name' => $item->name]);
            $it->icon = 'http://ddragon.leagueoflegends.com/cdn/'.$cdn_ver.'/img/item/'.$item->image->full;
            $it->description = $item->sanitizedDescription;
            $it->plaintext = (isset($item->plaintext)) ? $item->plaintext : '';
            $it->group = (isset($item->group)) ? $item->group : '';
            $it->gold_base = $item->gold->base;
            $it->gold_total = $item->gold->total;
            $it->depth = (isset($item->depth)) ? $item->depth : 0;
            
            $it->save();
            
            $tags = array();
            if(isset($item->tags)){
                foreach($item->tags as $tag){
                    $new_tag = ItemTags::firstOrNew(['item_id' => $item->id, 'name' => $tag]);
                    $new_tag->save();
                    array_push($tags, $new_tag);
                }
            }
            
            $froms = array();
            if(isset($item->from)){
                foreach($item->from as $from){
                    $new_from = ItemFrom::firstOrNew(['item_id' => $item->id, 'other_item_id' => $from]);
                    $new_from->save();
                    array_push($froms, $new_from);
                }
            }
            
            $intos = array();
            if(isset($item->into)){
                foreach($item->into as $into){
                    $new_into = ItemInto::firstOrNew(['item_id' => $item->id, 'other_item_id' => $into]);
                    $new_into->save();
                    array_push($intos, $new_into);
                }
            }
            
            // And now, get the maps at which it can be used
           
                   
            $it->itemTags = $tags;
            $it->itemFrom = $froms;
            $it->itemInto = $intos;
            array_push($items, $it);
        }
        return $items;
    }
    public function item_maps() {
        $map_names = array('1' => "Old Summoners Rift", '10' => 'Twisted Treeline', '11' => "Summoner's Rift", '12' => 'Howling Abyss');
        
        $maps_json = file_get_contents('https://global.api.pvp.net/api/lol/static-data/euw/v1.2/item?version=5.14.1&itemListData=maps&api_key=2767f871-228a-412a-9063-d754163404f4');
        $map_obj = json_decode($maps_json);
        
        $mapses = array();
        foreach ($map_obj->data as $item) {
            $maps_init = array(1,10,11,12);
            $maps = array();
            if(isset($item->maps)){
                $m = json_decode(json_encode($item->maps), true);
                $maps_init = array_diff($maps_init, array_keys($m));
            }
            foreach ($maps_init as $m) {
                $new_map = ItemMaps::firstOrNew(['item_id' => $item->id, 'map_id' => $m]);
                $new_map->map_name = $map_names[strval($m)];
                $new_map->save();
                array_push($maps, $new_map);
            }
            array_push($mapses, $maps);
        }
       return $mapses;
    }
    
    public function summoner_spells() {
        $cdn_ver = '5.16.1';
        
        $json = file_get_contents('https://global.api.pvp.net/api/lol/static-data/euw/v1.2/summoner-spell?spellData=image&api_key=2767f871-228a-412a-9063-d754163404f4');
        $obj = json_decode($json);
        
        $spells = array();
        foreach ($obj->data as $spell) {
            $new_spell = SummonerSpell::firstOrNew(['riot_id' => $spell->id, 'name' => $spell->name, 'key' => $spell->key]);
            $new_spell->icon = 'http://ddragon.leagueoflegends.com/cdn/'.$cdn_ver.'/img/spell/'.$spell->image->full;
            $new_spell->description = $spell->description;
            $new_spell->summoner_level = $spell->summonerLevel;
            $new_spell->save();
            array_push($spells, $new_spell);
        }
        return $spells;
    }
    
    public function meme_builds() {
        $path = storage_path() . "/fill/itemsets_memebuilds.json";
        
        if (!File::exists($path)) {
            throw new Exception("Invalid File");
        }
    
        $file = File::get($path);
        $obj = json_decode($file);
        
        $memebuilds = [];
        foreach($obj as $itemset) {
            $slug = \Illuminate\Support\Str::slug($itemset->name);
            $memebuild = MemeBuild::firstOrNew(['name' => $itemset->name, 'slug' => $slug]);
            $memebuild->description = $itemset->description;
            $video = preg_replace("/(?:https:\/\/|http:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?/", "http://www.youtube.com/embed/", $itemset->video);
            $memebuild->video = $video;
            if(isset($itemset->author)) {
                $memebuild->author = $itemset->author;
            }
            else {
                $memebuild->author = 'Anverid';
            }
            $memebuild->save();
            
            // Create the itemset
            $itemset_db = Itemset::firstOrNew(['name' => $itemset->name]);
            $itemset_db->point1 = $itemset->spell_order->point1;
            $itemset_db->point2 = $itemset->spell_order->point2;
            $itemset_db->point3 = $itemset->spell_order->point3;
            $itemset_db->max1 = $itemset->spell_order->max1;
            $itemset_db->max2 = $itemset->spell_order->max2;
            $itemset_db->max3 = $itemset->spell_order->max3;
            $itemset_db->champion_id = $itemset->champion;
            $itemset_db->summoner1 = $itemset->summoner_spells[0];
            $itemset_db->summoner2 = $itemset->summoner_spells[1];
            
            $memebuild->itemset = $itemset_db;
            $memebuild->itemset()->save($itemset_db);
            
            $blockStarting = ItemsetBlock::firstOrNew(['name' => 'Starting Items', 'type' => 1, 'itemset_id' => $itemset_db->id]);
            $itemset_db->itemset_blocks()->save($blockStarting);
            $startings_count = [];
            foreach ($itemset->starting_items as $value) {
                if(isset($startings_count[(string)$value])) {
                    $startings_count[(string)$value] = $startings_count[(string)$value] + 1;
                }
                else {
                    $startings_count[(string)$value] = 1;
                }
            }
            
            $counter = 0;
            foreach ($startings_count as $key => $value) {
                $item = Item::where('riot_id', $key)->first();
                if (!($blockStarting->items->contains($item->id))) {
                    $blockStarting->items()->save($item, ['count' => $value, 'order' => $counter]);
                }
                $counter++;
            }
            
            $blockFinal = ItemsetBlock::firstOrNew(['name' => 'Core Items', 'type' => 0, 'itemset_id' => $itemset_db->id]);
            $itemset_db->itemset_blocks()->save($blockFinal);            
            
            $items_count = [];
            foreach ($itemset->items as $value) {
                if(isset($items_count[(string)$value])) {
                    $items_count[(string)$value] = $items_count[(string)$value] + 1;
                }
                else {
                    $items_count[(string)$value] = 1;
                }
            }
            
            $counter = 0;
            foreach ($items_count as $key => $value) {
                $item = Item::where('riot_id', $key)->first();
                if (!($blockFinal->items->contains($item->id))) {
                    $blockFinal->items()->save($item, ['count' => $value, 'order' => $counter]);
                }
                $counter++;
            }
            
            $mb = MemeBuild::where(['id' => $memebuild->id])->with('itemset.itemset_blocks.items')->first();
            if(count($memebuilds) < 5) array_push($memebuilds, $mb);
        }
        return $memebuilds;
    }
    
    public function team_comps() {        
        $path = storage_path() . "/fill/itemsets_teamcomps.json";
        
        if (!File::exists($path)) {
            throw new Exception("Invalid File");
        }
    
        $file = File::get($path);
        $obj = json_decode($file);
        
        $teamcomps = [];
        foreach ($obj as $teamcomp) {
            $teamcomp->name = ucwords(strtolower($teamcomp->name));
            $slug = \Illuminate\Support\Str::slug($teamcomp->name);
            $team = TeamComp::firstOrNew(['name' => $teamcomp->name, 'slug' => $slug]);
            
            $team->description = $teamcomp->description;
            $video = preg_replace("/(?:https:\/\/|http:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?/", "http://www.youtube.com/embed/", $teamcomp->video);
            $team->video = $video;
            if(isset($teamcomp->author)) {
                $team->author = $teamcomp->author;
            }
            else {
                $team->author = 'Anverid';
            }
            $team->save();
            
            foreach($teamcomp->champions as $champion) {
                $custom = false;
                $customItemset;
                $champ = Champion::where('riot_id', $champion)->first();
                if(isset($teamcomp->itemsets)) {
                    foreach($teamcomp->itemsets as $itemset) {
                        if($itemset->champion == $champion) {
                            $custom = true;
                            $customItemset = $itemset;
                        }
                    }
                }
                $name = $custom ? $champ->name.' - '.$team->name : 'Frequent '.$champ->name;
                $itemset = Itemset::firstOrNew(['name' => $name, 'champion_id' => $champion]);
                
                $frequent_set = WinrateBuild::where(['champion_id' => $champion, 'bestrate' => false, 'order' => 1])
                                ->first()
                                ->itemsets()
                                ->first();
                $frequent_set->load('itemset_blocks', 'itemset_blocks.items');
                // Get the custom itemset - if it was not made, use the frequent set.
                // SPELL ORDER
                if($custom && isset($customItemset->spell_order) && count($customItemset->spell_order)) {
                    $itemset->point1 = $customItemset->spell_order->point1;
                    $itemset->point2 = $customItemset->spell_order->point2;
                    $itemset->point3 = $customItemset->spell_order->point3;
                    $itemset->max1 = $customItemset->spell_order->max1;
                    $itemset->max2 = $customItemset->spell_order->max2;
                    $itemset->max3 = $customItemset->spell_order->max3;
                }
                else {
                    $itemset->point1 = $frequent_set->point1;
                    $itemset->point2 = $frequent_set->point2;
                    $itemset->point3 = $frequent_set->point3;
                    $itemset->max1 = $frequent_set->max1;
                    $itemset->max2 = $frequent_set->max2;
                    $itemset->max3 = $frequent_set->max3;
                }
                
                // SUMMONER SPELLS
                if($custom && isset($customItemset->summoner_spells) && count($customItemset->summoner_spells)) {
                    $itemset->summoner1 = $customItemset->summoner_spells[0];   
                    $itemset->summoner2 = $customItemset->summoner_spells[1];
                }
                else {
                    $itemset->summoner1 = $frequent_set->summoner1;   
                    $itemset->summoner2 = $frequent_set->summoner2;                    
                }
                
                $team->itemsets()->save($itemset);
                
                $blockStarting = ItemsetBlock::firstOrNew(['name' => 'Starting Items', 'type' => 1, 'itemset_id' => $itemset->id]);
                $itemset->itemset_blocks()->save($blockStarting);
                
                // STARTING ITEMS
                if($custom && isset($customItemset->starting_items) && count($customItemset->starting_items)) {
                    // Read them from the custom itemset
                    $startings_count = [];
                    foreach ($customItemset->starting_items as $value) {
                        if(isset($startings_count[(string)$value])) {
                            $startings_count[(string)$value] = $startings_count[(string)$value] + 1;
                        }
                        else {
                            $startings_count[(string)$value] = 1;
                        }
                    }
                    $counter = 0;
                    foreach ($startings_count as $key => $value) {
                        $item = Item::where('riot_id', $key)->first();
                        if (!($blockStarting->items->contains($item->id))) {
                            $blockStarting->items()->save($item, ['count' => $value, 'order' => $counter]);
                        }
                        $counter++;
                    }
                }
                else {
                    $block = $frequent_set->itemset_blocks()->where('type', 1)->first();
                    $items = $block->items()->get();
                    foreach ($items as $item) {
                        if (!($blockStarting->items->contains($item->id))) {
                            $blockStarting->items()->save($item, ['count' => $item->pivot->count, 'order' => $item->pivot->order]);
                        }
                    }
                }
                
                $blockFinal = ItemsetBlock::firstOrNew(['name' => 'Core Items', 'type' => 0, 'itemset_id' => $itemset->id]);
                $itemset->itemset_blocks()->save($blockFinal);  
                
                // FINAL ITEMS
                if($custom && isset($customItemset->items) && count($customItemset->items)) {
                    foreach ($customItemset->items as $key) {
                        $item = Item::where('riot_id', $key)->first();
                        if (!($blockFinal->items->contains($item->id))) {
                            $blockFinal->items()->save($item, ['count' => $value, 'order' => $counter]);
                        }
                        $counter++;
                    }
                }
                else {
                    $block = $frequent_set->itemset_blocks()->where('type', 0)->first();
                    $items = $block->items()->get();
                    foreach ($items as $item) {
                        if (!($blockFinal->items->contains($item->id))) {
                            $blockFinal->items()->save($item, ['count' => $item->pivot->count, 'order' => $item->pivot->order]);
                        }
                    }
                }
                
            }
            array_push($teamcomps, $team);
        }
        
        return TeamComp::with('itemsets.itemset_blocks.items')->get();
        return $teamcomps;
        
        
    }
    
    
    /// WINRATE BUILDS
    public function winrate_builds($from, $to) {
        $champions = Champion::where('id','>=', $from)->where('id', '<', $to)->get();
        $itemsets = [];
        foreach($champions as $champion) {
            $html = file_get_html('http://champion.gg/champion/'.$champion->key.'/');
            
            // Get the roles first
            $roles = $html->find('.champion-profile ul li a h3');
            $rolecounter = 1;
            
            foreach($roles as $rolef) {
                $role = $rolef->plaintext;
                $role = trim($role);
                $html = file_get_html('http://champion.gg/champion/'.$champion->key.'/'.$role);
                $mostfrequent = WinrateBuild::firstOrNew(['champion_id' => $champion->riot_id, 'bestrate' => false, 'lane' => $role]);
                $bestwinrate = WinrateBuild::firstOrNew(['champion_id' => $champion->riot_id, 'bestrate' => true, 'lane' => $role]);
                
                $stats = $html->find('.build-wrapper .build-text strong');
                
                $mostfrequent->winrate = $stats[0]->plaintext;
                $mostfrequent->games = $stats[1]->plaintext;
                $mostfrequent->order = $rolecounter;
                $mostfrequent->save();
                
                $bestwinrate->winrate = $stats[2]->plaintext;
                $bestwinrate->games = $stats[3]->plaintext;
                $bestwinrate->order = $rolecounter;
                $bestwinrate->save();
                
                $frequent_set = Itemset::firstOrNew(['name' => ($role.' '.$champion->name.' Frequent'), 'champion_id' => $champion->riot_id]);
                $winrate_set = Itemset::firstOrNew(['name' => ($role.' '.$champion->name.' Winrate'), 'champion_id' => $champion->riot_id]);
                
                
                // Skill order
                $ret = $html->find('.skill-order div .skill-selections');
                
                // Most frequent skill order
                $abilitykeys = ['Nope', 'Q', 'W', 'E', 'R', 'Nope', 'Q', 'W', 'E', 'R'];
                $abilitymax = [];
                for ($i=1; $i < 5; $i++) {
                    $childs = $ret[$i]->children();
                    $counter = 0;
                    for ($j=0; $j < 18; $j++) { 
                        if($childs[$j]->class == 'selected') {
                            if($j == 0) {
                                $frequent_set->point1 = $abilitykeys[$i];
                            }
                            elseif($j == 1) {
                                $frequent_set->point2 = $abilitykeys[$i];
                            }
                            elseif($j == 2) {
                                $frequent_set->point3 = $abilitykeys[$i];
                            }
                            elseif($counter == 4) {
                                $abilitymax[$abilitykeys[$i]] = ($j+1);
                            }
                            $counter++;
                        } 
                    }
                }
                asort($abilitymax);
                $maxkeys = array_keys($abilitymax);
                
                $frequent_set->max1 = $maxkeys[0];
                $frequent_set->max2 = $maxkeys[1];
                $frequent_set->max3 = $maxkeys[2];
                
                // Highest winrate skill order
                $abilitymax = [];
                for ($i=6; $i < 10; $i++) {
                    $childs = $ret[$i]->children();
                    $counter = 0;
                    for ($j=0; $j < 18; $j++) { 
                        if($childs[$j]->class == 'selected') {
                            if($j == 0) {
                                $winrate_set->point1 = $abilitykeys[$i];
                            }
                            elseif($j == 1) {
                                $winrate_set->point2 = $abilitykeys[$i];
                            }
                            elseif($j == 2) {
                                $winrate_set->point3 = $abilitykeys[$i];
                            }
                            elseif($counter == 4) {
                                $abilitymax[$abilitykeys[$i]] = ($j+1);
                            }
                            $counter++;
                        } 
                    }
                }
                asort($abilitymax);
                $maxkeys = array_keys($abilitymax);
                
                $winrate_set->max1 = $maxkeys[0];
                $winrate_set->max2 = $maxkeys[1];
                $winrate_set->max3 = $maxkeys[2];
                
                
                
                // Summoner spells
                $ret = $html->find('.col-xxs-12 .summoner-wrapper a img');
                $counter = 0;
                foreach($ret as $summoner) { // 0 & 1 - most frequent, 2 & 3 - highest winrate
                    $key = preg_replace('/\/\/ddragon.leagueoflegends.com\/cdn\/5.16.1\/img\/spell\//', '', $summoner->src);
                    $key = preg_replace('/\.png/', '', $key);
                    $spell = SummonerSpell::where('key', $key)->first();
                    if($counter == 0) $frequent_set->summoner1 = $spell->riot_id;
                    elseif ($counter == 1) $frequent_set->summoner2 = $spell->riot_id;
                    elseif ($counter == 2) $winrate_set->summoner1 = $spell->riot_id;
                    elseif ($counter == 3) $winrate_set->summoner2 = $spell->riot_id;
                    $counter++;
                }
                
                $mostfrequent->itemsets()->save($frequent_set);
                $bestwinrate->itemsets()->save($winrate_set);
                
                // Final builds
                $ret = $html->find('.build-wrapper a img');
                $items = [];
                for ($i=0; $i < 6; $i++) { 
                    $key = preg_replace('/\/\/ddragon.leagueoflegends.com\/cdn\/5.16.1\/img\/item\//', '', $ret[$i]->src);
                    $key = preg_replace('/\.png/', '', $key);
                    array_push($items, $key);
                }
            
                $blockFinal = ItemsetBlock::firstOrNew(['name' => 'Frequent Core Items ('.$stats[0]->plaintext.' with '.$stats[1]->plaintext.' games)', 'type' => 0, 'itemset_id' => $frequent_set->id]);
                $frequent_set->itemset_blocks()->save($blockFinal);            
                
                $items_count = [];
                foreach ($items as $value) {
                    if(isset($items_count[(string)$value])) {
                        $items_count[(string)$value] = $items_count[(string)$value] + 1;
                    }
                    else {
                        $items_count[(string)$value] = 1;
                    }
                }
                
                $counter = 0;
                foreach ($items_count as $key => $value) {
                    $item = Item::where('riot_id', $key)->first();
                    if (!($blockFinal->items->contains($item->id))) {
                        $blockFinal->items()->save($item, ['count' => $value, 'order' => $counter]);
                    }
                    $counter++;
                }
                
                
                // Best Winrate Final Builds too!
                $items = [];                
                for ($i=6; $i < 12; $i++) { 
                    $key = preg_replace('/\/\/ddragon.leagueoflegends.com\/cdn\/5.16.1\/img\/item\//', '', $ret[$i]->src);
                    $key = preg_replace('/\.png/', '', $key);
                    array_push($items, $key);
                }
                $blockFinal = ItemsetBlock::firstOrNew(['name' => 'Best Winrate Core Items ('.$stats[2]->plaintext.' with '.$stats[3]->plaintext.' games)', 'type' => 0, 'itemset_id' => $winrate_set->id]);
                $winrate_set->itemset_blocks()->save($blockFinal); 
                
                $items_count = [];
                foreach ($items as $value) {
                    if(isset($items_count[(string)$value])) {
                        $items_count[(string)$value] = $items_count[(string)$value] + 1;
                    }
                    else {
                        $items_count[(string)$value] = 1;
                    }
                }
                
                $counter = 0;
                foreach ($items_count as $key => $value) {
                    $item = Item::where('riot_id', $key)->first();
                    if (!($blockFinal->items->contains($item->id))) {
                        $blockFinal->items()->save($item, ['count' => $value, 'order' => $counter]);
                    }
                    $counter++;
                }
                
                
                
                // Starting items
                $ret = $html->find('.build-wrapper');
                $imgs = $ret[2]->find('a img');
                
                $items = [];
                for ($i=0; $i < count($imgs); $i++) { 
                    $key = preg_replace('/\/\/ddragon.leagueoflegends.com\/cdn\/5.16.1\/img\/item\//', '', $imgs[$i]->src);
                    $key = preg_replace('/\.png/', '', $key);
                    if($key == 2009 || $key == 2010 ) $key = 2003;
                    array_push($items, $key);
                }
                $skillOrderString = $frequent_set->point1.$frequent_set->point2.$frequent_set->point3.', '.$frequent_set->max1.' > '.$frequent_set->max2.' > '.$frequent_set->max3;
                $blockStarting = ItemsetBlock::firstOrNew(['name' => 'Frequent Starters. Skill order: '.$skillOrderString, 'type' => 1, 'itemset_id' => $frequent_set->id]);
                $frequent_set->itemset_blocks()->save($blockStarting);
                
                $startings_count = [];
                foreach ($items as $value) {
                    if(isset($startings_count[(string)$value])) {
                        $startings_count[(string)$value] = $startings_count[(string)$value] + 1;
                    }
                    else {
                        $startings_count[(string)$value] = 1;
                    }
                }
                
                $counter = 0;
                foreach ($startings_count as $key => $value) {
                    $item = Item::where('riot_id', $key)->first();
                    if (!($blockStarting->items->contains($item->id))) {
                        $blockStarting->items()->save($item, ['count' => $value, 'order' => $counter]);
                    }
                    $counter++;
                }
                
                
                
                $items = [];
                $imgs = $ret[3]->find('a img');
                for ($i=0; $i < count($imgs); $i++) { 
                    $key = preg_replace('/\/\/ddragon.leagueoflegends.com\/cdn\/5.16.1\/img\/item\//', '', $imgs[$i]->src);
                    $key = preg_replace('/\.png/', '', $key);
                    if($key == 2009 || $key == 2010 ) $key = 2003;
                    array_push($items, $key);
                }
                $skillOrderString = $winrate_set->point1.$winrate_set->point2.$winrate_set->point3.', '.$winrate_set->max1.' > '.$winrate_set->max2.' > '.$winrate_set->max3;                
                $blockStarting = ItemsetBlock::firstOrNew(['name' => 'Best Winrate Starters. Skill order: '.$skillOrderString, 'type' => 1, 'itemset_id' => $winrate_set->id]);
                $winrate_set->itemset_blocks()->save($blockStarting);
                
                $startings_count = [];
                foreach ($items as $value) {
                    if(isset($startings_count[(string)$value])) {
                        $startings_count[(string)$value] = $startings_count[(string)$value] + 1;
                    }
                    else {
                        $startings_count[(string)$value] = 1;
                    }
                }
                
                $counter = 0;
                foreach ($startings_count as $key => $value) {
                    $item = Item::where('riot_id', $key)->first();
                    if (!($blockStarting->items->contains($item->id))) {
                        $blockStarting->items()->save($item, ['count' => $value, 'order' => $counter]);
                    }
                    $counter++;
                }
                
                //return WinrateBuild::where(['champion_id' => $champion->riot_id, 'bestrate' => false, 'lane' => $role])->with('itemsets.itemset_blocks.items')->first();
                
                array_push($itemsets, $frequent_set->name);
                array_push($itemsets, $winrate_set->name);
                
                $rolecounter++;
            }
            
        }
        $next = url().'/api/filldata/winrate-builds/'.$to.'/'.($to+($to-$from));
        return ['itemsets-done' => $itemsets, 'next' => $next];
    }
    
    public function role_builds() {
        $path = storage_path() . "/fill/itemsets_rolebuilds.json";
        
        if (!File::exists($path)) {
            throw new Exception("Invalid File");
        }
    
        $file = File::get($path);
        $obj = json_decode($file);
        
        $rolebuilds = [];
        foreach($obj as $itemset) {
            $rolebuild = RoleBuild::firstOrNew(['role' => $itemset->role]);
            $rolebuild->save();
            
            // Create the itemset
            $itemset_db = Itemset::firstOrNew(['name' => $itemset->role.' Items']);
            $itemset_db->type = 'global';
            $itemset_db->point1 = "N";
            $itemset_db->point2 = "N";
            $itemset_db->point3 = "N";
            $itemset_db->max1 = "N";
            $itemset_db->max2 = "N";
            $itemset_db->max3 = "N";
            $itemset_db->champion_id = 1;
            $itemset_db->summoner1 = 4;
            $itemset_db->summoner2 = 14;
            
            $rolebuild->itemset = $itemset_db;
            $rolebuild->itemsets()->save($itemset_db);
            
            foreach($itemset->itemset_blocks as $block) {
                $block_db = ItemsetBlock::firstOrNew(['name' => $block->name, 'type' => $block->type, 'itemset_id' => $itemset_db->id]);
                if(isset($block->hideIfSummonerSpell)) $block_db->hideIfSummonerSpell = $block->hideIfSummonerSpell;
                if(isset($block->showIfSummonerSpell)) $block_db->showIfSummonerSpell = $block->showIfSummonerSpell;
                $itemset_db->itemset_blocks()->save($block_db);
                $startings_count = [];
                foreach ($block->items as $value) {
                    if(isset($startings_count[(string)$value])) {
                        $startings_count[(string)$value] = $startings_count[(string)$value] + 1;
                    }
                    else {
                        $startings_count[(string)$value] = 1;
                    }
                }
                
                $counter = 0;
                foreach ($startings_count as $key => $value) {
                    $item = Item::where('riot_id', $key)->first();
                    if (!($block_db->items->contains($item->id))) {
                        $block_db->items()->save($item, ['count' => $value, 'order' => $counter]);
                    }
                    $counter++;
                }
            }
            $mb = RoleBuild::where(['id' => $rolebuild->id])->with('itemsets.itemset_blocks.items')->first();
            if(count($rolebuilds) < 5) array_push($rolebuilds, $mb);
        }
        return $rolebuilds;
    }
}
