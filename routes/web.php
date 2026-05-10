<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/clear-config', function () {
    Artisan::call('config:clear');
    return 'Config cleared!';
})->middleware('auth'); // remove middleware if needed