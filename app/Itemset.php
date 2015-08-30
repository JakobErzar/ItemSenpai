<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Itemset extends Model {

	protected $guarded = ['id'];
    
    public function champion() {
        return $this->belongsTo('App\Champion', 'champion_id', 'riot_id');
    }

    public function summoner1() {
        return $this->hasOne('App\SummonerSpell', 'riot_id', 'summoner1');
    }
    
    public function summoner2() {
        return $this->hasOne('App\SummonerSpell', 'riot_id', 'summoner2');
    }
    
    public function itemset_blocks() {
        return $this->hasMany('App\ItemsetBlock', 'itemset_id', 'id');
    }
    
    public function bildernus() {
        return $this->morphTo();
    }
}
