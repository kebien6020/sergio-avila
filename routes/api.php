<?php

use Illuminate\Http\Request;
use App\Item;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/autosuggest', function(Request $request) {
  if ($request->term) {
    return Item::search($request->term)
      ->take(15)
      ->get()
      ->unique('father')
      ->load('images')
      ->map(function($item) {
        return collect([
          'name' => $item->name,
          'image' => $item->images->first()->url
        ]);
      })
      ->values();
  }

  return Item::all();
});

Route::middleware('api')->get('/existences/{code}', function ($code) {
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
