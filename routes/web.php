<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('properties.index');
});


Route::resource('properties', PropertyController::class);