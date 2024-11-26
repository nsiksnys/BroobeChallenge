<?php

use App\Http\Controllers\MetricHistoryRunController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(MetricHistoryRunController::class)->group(function () {
    Route::get('/', 'index')->name('metrics_index');
    Route::get('/list', 'list')->name('metrics_list');
});
