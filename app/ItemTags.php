<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTags extends Model {

	protected $guarded = ['id'];
    public $timestamps = false;
    
    public function name() {
        return $this->belongsTo('App\Item', 'item_id', 'riot_id');
    }
    
}
