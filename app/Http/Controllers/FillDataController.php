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
            for ($i=0; $i < 4; $i++) { 
                $spell = $champ->spells[$i];
                $new_spell = Spell::firstOrNew(['name' => $spell->name, 'key' => $spell->key, 'champion_id' => $champ->id]);
                $new_spell->max_rank = $spell->maxrank;
                $new_spell->symbol = $symbols[$i];
                $new_spell->icon = 'http://ddragon.leagueoflegends.com/cdn/'.$cdn_ver.'/img/spell/'.$spell->image->full;
                $new_spell->save();
                array_push($spells, $new_spell);
            }
                   
            $champion->save();
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
                   
            $it->save();
            $it->ItemTags = $tags;
            $it->ItemFrom = $froms;
            $it->ItemInto = $intos;
            array_push($items, $it);
        }
        return $items;
    }
}
