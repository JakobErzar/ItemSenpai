<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

	protected $guarded = [];

    //protected $primaryKey = 'riot_id';
    
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
    
    public function itemsetBocks() {
        return $this->belongsToMany('App\ItemsetBlock',  'items_itemset_blocks', 'item_id', 'id')->withPivot('count', 'order')->withTimestamps();
    }
    
    public function scopeFinalItem($query) {
        return $query->doesntHave('itemInto');
    }
    
    public function scopeNotGoodItemThingy($query) {
        $ignoreGroup = ['HealthPotion', 'ManaPotion', 'GreenWard', 'PinkWard', 'Trinket', 'Flasks', 'DoransShowdown', 'TheBlackSpear'];
        $ignoreID = [2050, 3170];
        return $query->whereNotIn('group', $ignoreGroup)->whereNotIn('riot_id', $ignoreID);
    }
}
