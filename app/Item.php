<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

	protected $guarded = ['id'];

    public function ItemTags() {
        return $this->hasMany('App\ItemTags', "item_id", "riot_id");
    }
    
    public function ItemFrom() {
        return $this->hasMany('App\ItemFrom', "item_id", "riot_id");
    }
    
    public function ItemInto() {
        return $this->hasMany('App\ItemInto', "item_id", "riot_id");
    }
    
    public function ItemMaps() {
        return $this->hasMany('App\ItemMaps', "item_id", "riot_id");
    }
}
