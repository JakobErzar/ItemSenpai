<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemFrom extends Model {

	protected $guarded = [];
    public $timestamps = false;
    
    public function Item() {
        return $this->belongsTo('App\Item', 'other_item_id', 'riot_id');
    }

}
