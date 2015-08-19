<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Champion extends Model {

	protected $guarded = ['id'];
    
    public function spells(){
        return $this->hasMany('App\Spell', 'champion_id', 'riot_id');
    }

}
