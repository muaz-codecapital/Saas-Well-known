<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Notes API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notes', [App\Http\Controllers\Api\NotesController::class, 'index']);
    Route::post('/notes', [App\Http\Controllers\Api\NotesController::class, 'store']);
    Route::get('/notes/{note}', [App\Http\Controllers\Api\NotesController::class, 'show']);
    Route::put('/notes/{note}', [App\Http\Controllers\Api\NotesController::class, 'update']);
    Route::delete('/notes/{note}', [App\Http\Controllers\Api\NotesController::class, 'destroy']);
    Route::post('/notes/{note}/attachments', [App\Http\Controllers\Api\NotesController::class, 'addAttachment']);
    Route::delete('/notes/{note}/attachments/{attachment}', [App\Http\Controllers\Api\NotesController::class, 'removeAttachment']);
});
