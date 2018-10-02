<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Item;
use App\Family;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});

Route::get('/search', function (Request $req) {

    $codes = false;

    $items = Item::with(['images', 'family']);
    if ($req->has('fam')) {
      $codes = json_decode($req->query('fam'), true);
      if (!is_null($codes)) {
        $items = $items->whereIn('family_code', $codes);
      }
    }
    $items = $items->get();


    $families = collect();
    if ($codes) {
      $families = Family::whereIn('code', $codes);
    } else {
      $families = Family::all();
    }
    $families = $families->get();

    return view('search', [
      'items' => $items,
      'families' => $families
    ]);
});
