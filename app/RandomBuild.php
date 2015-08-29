<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RandomBuild extends Model {

	protected $guarded = ['id'];
    
    public function itemsets() {
        return $this->morphMany('App\Itemset', 'bildernus');
    }

}
