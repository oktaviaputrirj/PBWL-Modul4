<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\ProgramStudiController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('/program-studi', [ProgramStudiController::class, 'index']);

    Route::apiResource('/mata-kuliah', MataKuliahController::class);
});
