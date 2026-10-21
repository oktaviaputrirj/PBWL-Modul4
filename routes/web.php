<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/mata-kuliah', 'mata-kuliah')
    ->name('klien.mata-kuliah');