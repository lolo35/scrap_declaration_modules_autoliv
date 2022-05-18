<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinesController;
use App\Http\Controllers\DepartamentsController;
use App\Http\Controllers\PartsController;
use App\Http\Controllers\StationsController;
use App\Http\Controllers\DefectCodesController;
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

Route::get('/lines', [LinesController::class, 'getLines']);
Route::get('/departaments', [DepartamentsController::class, 'getDepartaments']);
Route::get('/parts', [PartsController::class, 'getParts']);
Route::get('/stations', [StationsController::class, 'getStations']);
Route::get('/defect_codes', [DefectCodesController::class, 'getDefectCodes']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
