<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HashController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/object/get_all_records', [HashController::class, 'index']);
Route::post('/object', [HashController::class, 'create']);
Route::get('/object/{key}', [HashController::class, 'show']);
