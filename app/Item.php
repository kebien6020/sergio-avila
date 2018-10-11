<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Item extends Model
{
    use Searchable;

    public $asYouType = true;

    /**
    * Get the indexable data array for the model.
    *
    * @return array
    */
    public function toSearchableArray() {
      return [
        'id' => $this->id,
        'name' => $this->name,
        'description_1' => $this->description_1,
        'description_2' => $this->description_2,
        'code' => $this->code,
        'color' => $this->color,
        'capacity' => $this->capacity,
        'material' => $this->material,
        'size' => $this->size,
        'print_technique' => $this->print_technique,
        'print_area' => $this->print_area,

        'family' => $this->family->name,
      ];
    }


    public function family() {
      return $this->belongsTo('App\Family', 'family_code', 'code');
    }

    public function images() {
      return $this->hasMany('App\ItemImage', 'item_code', 'code');
    }
}
