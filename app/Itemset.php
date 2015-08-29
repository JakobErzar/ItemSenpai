<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Itemset extends Model {

	protected $guarded = ['id'];
    
    public function champion() {
        return $this->belongsTo('App\Champion', 'champion_id', 'riot_id');
    }

    public function summoner1() {
        return $this->hasOne('App\SummonerSpell', 'summoner1', 'riot_id');
    }
    
    public function summoner2() {
        return $this->hasOne('App\SummonerSpell', 'summoner2', 'riot_id');
    }
    
    public function itemset_blocks() {
        return $this->hasMany('App\ItemsetBlock', 'id', 'id');
    }
    
    public function bildernus() {
        return $this->morphTo();
    }
}
