<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public function items() {
      return $this->hasMany('App\Item', 'family_code', 'code');
    }

    // Genera una version del nombre de family que se puede
    // usar en URLs
    public function getSlugAttribute() {
      // Convertir a minuscula. Usando funcion compatible con UTF-8
      $res = mb_strtolower($this->name, 'UTF-8');
      // Cambiar espacios por guiones
      $res = str_replace(' ', '-', $res);
      // Quitar comas si las hay
      $res = str_replace(',', '', $res);
      // Remover diacriticos (tildes, virgulilla, dieresis)
      $res = iconv('UTF-8', 'ASCII//TRANSLIT', $res);

      return $res;
    }
}
