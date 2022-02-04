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

Route::get('company_search', [\App\Http\Controllers\CompanySearchController::class, 'form']);
Route::post('company_search', [\App\Http\Controllers\CompanySearchController::class, 'search']);

Route::get('TaxWebAPI', [\App\Http\Controllers\TaxWebAPITestController::class, 'index']);
Route::post('TaxWebAPI', [\App\Http\Controllers\TaxWebAPITestController::class, 'get1'])->name('get1');
