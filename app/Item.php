<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function family() {
      return $this->belongsTo('App\Family', 'family_code', 'code');
    }

    public function images() {
      return $this->hasMany('App\ItemImage', 'item_code', 'code');
    }
}
