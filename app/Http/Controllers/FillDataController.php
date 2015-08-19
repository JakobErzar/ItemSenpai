<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Champion;
use App\Spell;

class FillDataController extends Controller {

	public function champions() {
        $json = file_get_contents('https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion?champData=all&api_key=2767f871-228a-412a-9063-d754163404f4');
        $obj = json_decode($json);
        
        $champs = array();
        foreach($obj->data as $champ){
         
            $champion = Champion::firstOrNew(['riot_id' => $champ->id, 'key' => $champ->key, 'name' => $champ->name]);
            $champion->icon = 'http://ddragon.leagueoflegends.com/cdn/5.2.1/img/champion/'.$champ->key.'.png';
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
                $new_spell->icon = 'http://ddragon.leagueoflegends.com/cdn/5.2.1/img/spell/'.$spell->key.'.png';
                $new_spell->save();
                array_push($spells, $new_spell);
            }
                   
            $champion->save();
            $champion->spells = $spells;
            array_push($champs, $champion);
        }
        return $champs;
    }

}
