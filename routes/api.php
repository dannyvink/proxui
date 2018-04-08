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

Route::put('/history/{id}', function(Request $request, $id) {
    $history = History::findOrFail($id);
    $newName = !empty($request->get('name')) ? $request->get('name') : $history->identifier;
    $history->name = $newName;
    $history->save();
    return $history;
});

Route::post('/terminal', function(Proxmark3 $scanner, Request $request) {
    return $scanner->executeCommand($request->get('input'), true);
});

Route::get('/ip', function() {
    $result = @file_get_contents("https://api.ipify.org/?format=json");
    if (!empty($result)) {
        $result = json_decode($result, true)["ip"];
    }

    return ["result" => $result];
});

Route::post('/wifi', function(Request $request) {
    $result = false;
    if ($request->has('ssid') && $request->has('password')) {
        $file = "/etc/wpa_supplicant/wpa_supplicant-" . config('scanner.wifi_interface') . ".conf";
        shell_exec('sudo wpa_passphrase "' . $request->get('ssid') . '" "' . $request->get('password') . '" > ' . $file);
        shell_exec("sudo reboot");

        $result = @file_get_contents("https://api.ipify.org/?format=json");
        if (!empty($result)) {
            $result = json_decode($result, true)["ip"];
        }
    }
    return ['result' => $result];
});