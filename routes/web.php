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

function getItemsForPage(Request $req) {
  $items = Item::with(['images', 'family']);
  if ($req->has('fam')) {
    $codes = json_decode($req->query('fam'), true);
    if (!is_null($codes)) {
      $items = $items->whereIn('family_code', $codes);
    }
  }
  $items = $items->paginate(15);

  return $items;
}

Route::get('/partials/items', function (Request $req) {
  $items = getItemsForPage($req);

  return view('itempage', ['items' => $items]);
});

Route::get('/search', function (Request $req) {

    $codes = false;
    if ($req->has('fam')) {
      $codes = json_decode($req->query('fam'), true);
    }

    $items = getItemsForPage($req->merge(['page' => '1']));


    $families = collect();
    if ($req->has('fam')) {
      $families = Family::whereIn('code', $codes)->get();
    } else {
      $families = Family::all();
    }

    return view('search', [
      'items' => $items,
      'families' => $families
    ]);
});

Route::get('/item/{code}', function ($code) {
  $code = str_replace('_', ' ', $code);
  $items = Item::where(['code' => $code])->get();
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

Route::get('/api/existences/{code}', function ($code) {
  $client = new nusoap_client(
    realpath('../public/api.wsdl'),
    'wsdl'
  );
  $err = $client->getError();

  if ($err) {
  	return collect([
      'success' => false,
      'error' => $err,
      'debug' => $client->getDebug()
    ])->toJson();
  }

  $params = [
    'codigo' => $code,
    'distribuidor' => 'COL0015',
  ];

  $result = $client->call('existencias', $params);

  if ($client->fault) {
    return collect([
      'success' => false,
      'error' => 'Fault (Expect - The request contains an invalid SOAP body)',
      'debug' => $result->faultstring
    ])->toJson();
  }

  $err = $client->getError();

  if ($err) {
    return collect([
      'success' => false,
      'error' => $err,
      'result' => $result,
    ])->toJson();
  }

  $res = $result['existenciasResult'];
  $res['success'] = true;

  return collect($res)->toJson();
});
