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
    shell_exec('git fetch');
    $result = shell_exec('git status');
    $updateable = false;
    if (preg_match("/behind (.+) by/im", $result)) {
        $updateable = true;
    }
    return view('scan', ['updateable' => $updateable]);
});

Route::get('/update', function() {
    $pull = shell_exec('cd ' . base_path() . ' && git pull');
    $migrate = shell_exec('cd ' . base_path() . ' && php artisan migrate');
    return '<pre>' . $pull . '</pre><pre>' . $migrate . '</pre><a href="/">Done</a>';
});

Route::get('/history', function () {
    return view('history');
});

Route::get('/terminal', function () {
    return view('terminal');
});
