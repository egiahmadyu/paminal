<?php

use App\Http\Controllers\HelperController;
use App\Http\Controllers\PoldaController;
use App\Http\Controllers\YanduanController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('all-polda', [PoldaController::class, 'getAllPolda']);
Route::get('all-pangkat', [HelperController::class, 'getAllPangkat']);
Route::get('get-unit/{bag_den}', [HelperController::class, 'getUnit']);

Route::post('yanduan', [YanduanController::class, 'getData']);
Route::post('get-data-yanduan', [YanduanController::class, 'getDataYanduan']);
Route::get('import-pangkat', [YanduanController::class, 'importPangkat']);
