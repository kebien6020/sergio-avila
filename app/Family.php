<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public function items() {
      return $this->hasMany('App\Item', 'family_code', 'code');
    }
}
