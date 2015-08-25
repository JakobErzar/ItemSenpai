<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

	protected $guarded = ['id'];

    public function itemTags() {
        return $this->hasMany('App\ItemTags', "item_id", "riot_id")->select(['item_id', 'name']);
    }
    
    public function itemFrom() {
        return $this->hasMany('App\ItemFrom', "item_id", "riot_id");
    }
    
    public function itemInto() {
        return $this->hasMany('App\ItemInto', "item_id", "riot_id");
    }
    
    public function itemMaps() {
        return $this->hasMany('App\ItemMaps', "item_id", "riot_id");
    }
}
