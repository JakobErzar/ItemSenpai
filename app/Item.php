<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

	protected $guarded = [];

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
        return $this->belongsToMany('App\ItemsetBlock',  'items_itemset_blocks', 'id', 'riot_id')->withPivot('count', 'order')->withTimestamps();
    }
    
    public function scopeFinalItem($query) {
        return $query->doesntHave('itemInto');
    }
    
    public function scopeNotGoodItemThingy($query) {
        $ignorethem = ['HealthPotion', 'ManaPotion', 'GreenWard', 'PinkWard', 'Trinket', 'Flasks', 'DoransShowdown', 'TheBlackSpear'];
        $ignoreid = [2050, 3170];
        return $query->whereNotIn('group', $ignorethem)->whereNotIn('riot_id', $ignoreid)->whereHas('itemTags', function($query) {
            return $query->where('name', '!=', 'Lane')->where('name', '!=', 'Bilgewater');
        });
    }
}
