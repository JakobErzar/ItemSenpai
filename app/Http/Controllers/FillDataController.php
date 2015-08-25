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

class FillDataController extends Controller {
    
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
}
