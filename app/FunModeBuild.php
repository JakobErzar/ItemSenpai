<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class FunModeBuild extends Model {

	protected $guarded = ['id'];
    
    public function itemsets() {
        return $this->morphMany('App\Itemset', 'bildernus');
    }

}
