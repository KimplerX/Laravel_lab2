<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\QueryBuilderController;

Route::prefix('qb')->group(function () {
    Route::get('/all', [QueryBuilderController::class, 'all']);
    Route::get('/filter', [QueryBuilderController::class, 'filter']);
    Route::get('/selected-columns', [QueryBuilderController::class, 'selectedColumns']);
    Route::get('/paginated', [QueryBuilderController::class, 'paginated']);
    Route::get('/aggregates', [QueryBuilderController::class, 'aggregates']);
    Route::get('/join-inner', [QueryBuilderController::class, 'joinInner']);
    Route::get('/join-left', [QueryBuilderController::class, 'joinLeft']);
    Route::get('/join-right', [QueryBuilderController::class, 'joinRight']);
    Route::get('/iud', [QueryBuilderController::class, 'insertUpdateDelete']);
});

use App\Http\Controllers\RawDemoController;

Route::get('/raw-demo', [RawDemoController::class, 'index']);

use App\Http\Controllers\RelationshipController;

Route::get('/relationships-demo', [RelationshipController::class, 'demonstrate']);