<?php

use App\Http\Controllers\MergeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Menus Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MergeController::class, 'index']);
Route::post('{type}/import', [MergeController::class, 'import']);
