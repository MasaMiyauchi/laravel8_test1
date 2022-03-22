<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('company_search', [\App\Http\Controllers\CompanySearchController::class, 'form'])->name('company_search');
Route::post('company_search', [\App\Http\Controllers\CompanySearchController::class, 'search']);

Route::get('TaxWebAPI', [\App\Http\Controllers\TaxWebAPITestController::class, 'index']);
Route::post('TaxWebAPI-get1', [\App\Http\Controllers\TaxWebAPITestController::class, 'get1'])->name('get1');
Route::post('TaxWebAPI-tgt_date_get', [\App\Http\Controllers\TaxWebAPITestController::class, 'tgt_date_get'])->name('tgt_date_get');
Route::post('TaxWebAPI-compNo_comp_info', [\App\Http\Controllers\TaxWebAPITestController::class, 'compNo_comp_info'])->name('compNo_comp_info');
