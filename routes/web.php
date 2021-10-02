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

function getCodesFromRequest(Request $req) {
  $codes = false;
  if ($req->has('fam')) {
    $codeLookup = App\Family::all()
      ->mapWithKeys(function($fam) {
        return [$fam->slug => $fam->code];
      });

    $codes = collect(explode(',', $req->fam))
      ->map(function ($slug) use ($codeLookup) {
          if (!$codeLookup->has($slug))
            return null;
          return $codeLookup[$slug];
      })
      ->filter(function ($val) {
        return !is_null($val);
      });
  }

  return $codes;
}

function getItemsForPage(Request $req) {
  $items = Item::with(['images', 'family']);

  $codes = getCodesFromRequest($req);
  if ($codes) {
    $items = $items->whereIn('family_code', $codes);
  }
  $items = $items->paginate(15);

  return $items;
}

Route::get('/partials/items', function (Request $req) {
  $items = getItemsForPage($req);

  return view('itempage', ['items' => $items]);
});

Route::get('/search', function (Request $req) {

    $codes = getCodesFromRequest($req);

    $items = getItemsForPage($req->merge(['page' => '1']));


    $families = collect();
    if ($req->has('fam')) {
      $families = Family::whereIn('code', $codes)->get();
    } else {
      $families = Family::all();
    }

    return view('search', [
      'items' => $items,
      'families' => $families,
      'allFamilies' => Family::all()->sortBy('name'),
    ]);
});

Route::get('/item/{slug}', function ($slug) {
  $items = Item::all()
    ->filter(function ($item) use ($slug) {
      return $item->slug === $slug;
    });

  if ($items->count() <= 0) {
    return abort(404);
  }

  $item = $items->first();

  $moreColors = Item::where('father', $item->father)
    ->where('code', '!=', $item->code)
    ->get();

  return view('item', [
    'item' => $item,
    'moreColors' => $moreColors,
  ]);
});
