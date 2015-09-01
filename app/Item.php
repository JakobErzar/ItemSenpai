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
        $ignoreGroup = ['HealthPotion', 'ManaPotion', 'GreenWards', 'PinkWards', 'Trinket', 'Flasks', 'DoransShowdown', 'TheBlackSpear', 'RelicBase', 'BootsTeleport'];
        $ignoreID = [2050, 3170, 3613, 3902, 3901, 3903, 3345, 3652, 3611, 3180, 3198, 3104, 3840, 3430, 3181, 3112, 3616, 3903, 3622, 1063, 
            3434, 3745, 3185, 3090, 1062, 3911, 3744, 3829, 3159, 3187, 3623, 3029, 3348, 3431, 3290, 2047, 3137, 2009, 3624, 3154, 3621, 
            3625, 3615, 3924, 3617, 3504, 3612, 3626, 2051, 3150, 3084, 3184, 3614, 3244, 3243, 3242, 3241, 3240, 1056, 1054, 1055];
        return $query->whereNotIn('group', $ignoreGroup)->whereNotIn('riot_id', $ignoreID);
    }
}
