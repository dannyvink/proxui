<?php

use Illuminate\Http\Request;
use App\Library\Proxmark3;
use App\History;

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

Route::post('/scanner/clone', function(Proxmark3 $scanner, Request $request) {
    return $scanner->clone($request->get('type'), $request->get('identifier'));
});

Route::get('/history', function() {
    return History::all();
});

Route::post('/terminal', function(Proxmark3 $scanner, Request $request) {
    return $scanner->executeCommand($request->get('input'), true);
});

Route::put('/history/{id}', function(Request $request, $id) {
    $history = History::findOrFail($id);
    $newName = !empty($request->get('name')) ? $request->get('name') : $history->identifier;
    $history->name = $newName;
    $history->save();
    return $history;
});