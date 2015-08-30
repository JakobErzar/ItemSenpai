<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemsetBlock extends Model {

	protected $guarded = ['id'];
    
    public function items() {
        return $this->belongsToMany('App\Item',  'items_itemset_blocks', 'itemset_block_id', 'item_id')->withPivot('count', 'order')->withTimestamps();
    }

}
