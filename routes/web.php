<?php

use Illuminate\Support\Facades\Route;

Route::get('/docs', function () {
    return response()->file(base_path('api.json'));
});


Route::get('/', function () {
    return view('welcome');
});
