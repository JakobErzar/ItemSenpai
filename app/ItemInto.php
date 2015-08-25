<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemInto extends Model {

	protected $guarded = [];
    public $timestamps = false;
    
    public function item() {
        return $this->belongsTo('App\Item', 'other_item_id', 'riot_id');
    }
}
