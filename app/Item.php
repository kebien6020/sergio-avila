<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Item extends Model
{
    use Searchable;

    public $asYouType = true;

    public function family() {
      return $this->belongsTo('App\Family', 'family_code', 'code');
    }

    public function images() {
      return $this->hasMany('App\ItemImage', 'item_code', 'code');
    }
}
