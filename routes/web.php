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

Route::get('/', function () {
    $updateable = false;
    if (!session()->has('checked_for_update')) {
        shell_exec('git fetch');
    }
    $result = shell_exec('git status');
    if (preg_match("/behind (.+) by/im", $result)) {
        $updateable = true;
    }
    session(['checked_for_update' => date("Y-m-d H:i:s")]);
    return view('scan', ['updateable' => $updateable, 'last_update_check' => session('checked_for_update')]);
});

Route::get('/update', function() {
    $directory = getcwd();
    chdir(base_path());
    $pull = shell_exec('git pull');
    $npm = shell_exec('npm run prod');
    $migrate = shell_exec('php artisan migrate');
    chdir($directory);
    return '<pre>' . $pull . '</pre><pre>' . $npm . '</pre><pre>' . $migrate . '</pre><a href="/">Done</a>';
});

Route::get('/history', function () {
    return view('history');
});

Route::get('/terminal', function () {
    return view('terminal');
});

Route::get('/wifi', function () {
    return view('wifi');
});
