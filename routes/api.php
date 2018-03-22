<?php

use Illuminate\Http\Request;
use App\Library\Proxmark3;

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

Route::get('/scanner/status', function(Proxmark3 $scanner) {
    return $scanner->toJson();
});

Route::get('/scanner/search/{type}', function(Proxmark3 $scanner, $type) {
    if ($type === 'lf') return $scanner->searchLowFrequency();
    return $scanner->searchHighFrequency();
});
